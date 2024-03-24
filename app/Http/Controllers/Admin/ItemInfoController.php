<?php

namespace App\Http\Controllers\Admin;

use item;
use Carbon\Carbon;
use App\Models\ItemInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreItemInfoRequest;

class ItemInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            $search = $request->input('search');
            $status = $request->input('status'); // 'active', 'inactive', or null 
            $query = ItemInfo::whereIn('status', [0, 1])->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter 
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $fillableColumns = (new ItemInfo())->getFillable(); // Fetch all fillable columns
                    $fillableColumns = array_diff($fillableColumns, ['published', 'request_status', 'approved']); // Exclude 'published' column
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }


            $query = $query->paginate($perPage);

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
            // Handle the exception, log it, and return an appropriate error response
        }
        return view('admin.item.index', with(['products' => $query,]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemInfoRequest $request)
    {
        DB::beginTransaction();

        try {

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $thumbnail_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $thumbnail->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/products'))) {
                    File::makeDirectory(public_path('uploads/products'), 0777, true, true);
                }
                $thumbnail->move('uploads/products', $thumbnail_name);
            } else {
                $thumbnail_name = 'default.png';
            }

            $validatedData = $request->validated();

            if ($request->input('tax')) {
                $taxPercentage = $request->input('tax') / 100;
                $publishedPrice = $request->input('published_price');
                $taxAmount = $publishedPrice * $taxPercentage;
            }
            if ($request->input('discount_type')) {
                $discountPercentage = $request->input('discount_type') / 100;
                $publishedPrice = $request->input('published_price');
                $discountAmount = $publishedPrice * $discountPercentage;
            }

            $itemInfo = ItemInfo::create($validatedData);
            $slug = Str::slug($itemInfo->name);
            $uniqueSlug = $this->makeUniqueSlug($slug);
            $itemInfo->slug = $uniqueSlug;
            $itemInfo->tax_amount = $taxAmount;
            $itemInfo->discount_amount = $discountAmount;

            $itemInfo->thumbnail = $thumbnail_name;

            $itemInfo->current_stock = 10;
            $itemInfo->stock_status = 10;
            $itemInfo->min_qty = 1;
            $itemInfo->approved_status = true;
            $itemInfo->status = true;

            $code = isset($itemInfo->id) ? $itemInfo->id : 'unknown_id';
            $itemInfo->code = $code . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $itemInfo->save();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'ItemInfo created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating ItemInfo: ' . $e->getMessage());
        }
    }


    private function makeUniqueSlug($originalSlug)
    {
        $count = 1;
        $slug = $originalSlug;

        // Keep incrementing the count until a unique slug is found
        while (ItemInfo::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        return $slug;
    }


    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $itemInfo = ItemInfo::where('id', $id)->first();
        return view('admin.item.show', with(['itemInfo' => $itemInfo]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

        $itemInfo = ItemInfo::where('id', $id)->first();

        return view('admin.item.edit', with(['itemInfo' => $itemInfo,]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            if ($request->input('tax')) {
                $taxPercentage = $request->input('tax') / 100;
                $publishedPrice = $request->input('published_price');
                $taxAmount = $publishedPrice * $taxPercentage;
            }
            if ($request->input('discount_type')) {
                $discountPercentage = $request->input('discount_type') / 100;
                $publishedPrice = $request->input('published_price');
                $discountAmount = $publishedPrice * $discountPercentage;
            }

            $thumbnail_name = $this->uploadThumbnail($request);
            $itemInfo = ItemInfo::findOrFail($id);

            $itemInfo->update($request->all());

            $itemInfo->thumbnail = $thumbnail_name;
            $itemInfo->tax_amount = $taxAmount;
            $itemInfo->discount_amount = $discountAmount;

            $itemInfo->current_stock = $request->current_stock ?? 10;
            $itemInfo->stock_status =  $request->stock_status ?? 1;
            $itemInfo->min_qty = 1;
            $slug = Str::slug($itemInfo->name);
            $itemInfo->slug = $this->makeUniqueSlug($slug);
            $itemInfo->code = $this->generateItemCode($itemInfo->id);

            $itemInfo->save();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'ItemInfo updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating ItemInfo: ' . $e->getMessage());
        }
    }

    private function uploadThumbnail($request)
    {
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $slug = Str::slug($request->name);
            $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
            $thumbnail_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $thumbnail->getClientOriginalExtension();

            if (!File::exists(public_path('uploads/products'))) {
                File::makeDirectory(public_path('uploads/products'), 0777, true, true);
            }
            $thumbnail->move('uploads/products', $thumbnail_name);
        } else {
            $thumbnail_name = 'default.png';
        }

        return $thumbnail_name;
    }

    private function generateItemCode($itemId)
    {
        return $itemId ? $itemId . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT) : 'unknown_id';
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemInfo $itemInfo)
    {
        //
    }

    public function loadProduct()
    {
        $items = ItemInfo::latest()->paginate(10);

        // if ($request->expectsJson()) {
        return response()->json([
            'message' => 'success',
            'items' => $items,
        ]);
    }

    public function getProduct($productId)
    {
        $itemInfo = ItemInfo::where('id', $productId)->first();

        return response()->json([
            'message' => 'success',
            'items' => $itemInfo,
        ]);
    }


    public function findSetPrice(Request $request)
    {
        $itemInfo = ItemInfo::where('id', $request->id)->first();

        return view('admin.item.setPrice', with(['itemInfo' => $itemInfo]));
    }



    public function setPrice(Request $request)
    {
        $itemInfo = ItemInfo::where('id', $request->id)->first();

        $itemInfo->update($request->all());
        $itemInfo->published_price = $request->published_price;
        $itemInfo->current_stock = 0;
        $itemInfo->stock_status = 0;
        $itemInfo->approved_status = true;
        $itemInfo->status = true;


        $itemInfo->save();

        // DB::commit();

        return redirect()->route('admin.products.index')
            ->with('success', 'ItemInfo updated successfully');
        // } catch (\Exception $e) {

        //     DB::rollBack();
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('error', 'Error updating ItemInfo: ' . $e->getMessage());
        // }
    }
}
