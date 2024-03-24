<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sell;
use App\Models\User;
use App\Models\ItemInfo;
use App\Models\SellsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreSellRequest;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $filters = $request->only(['search', 'per_page']);

            $users = User::latest();

            $query = Sell::with(['sellsItems'])
                ->where('sells_type', 'pos-sell')
                ->latest('id')
                ->filter($filters);

            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $fillableColumns = (new Sell())->getFillable();
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $data = $query->paginate($perPage);

            return view('admin.sales.index', [
                'users' => $users, 'sells' => $data,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Output the error message for debugging
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 12);
            $page = $request->query('page', 1);
            $search = $request->input('search');

            $query = ItemInfo::where('status', 1)
                ->where('approved_status', 1)
                ->latest('id');

            $users = User::all();

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%')
                        ->orWhere('sku', 'like', '%' . $search . '%');
                });
            }

            $data = $query->paginate($perPage, ['*'], 'page', $page);

            if ($request->expectsJson()) {
                // Render the Blade partial with the items and convert it to a string
                $partialHtml = View::make('admin.sales.partials.product_item_template', [
                    'items' => $data,
                ])->render();

                // Return the HTML content as a JSON response
                return response()->json(['html' => $partialHtml]);
            }

            if ($request->expectsJson() && $request->has('page')) {
                // return view('admin.sales.partials.product_item', with(['items' => $data]));
                $partialHtml = View::make('admin.sales.partials.product_item', [
                    'items' => $data,
                ])->render();

                return response()->json(['html' => $partialHtml]);
            }

            return view('admin.sales.create', [
                'users' => $users,
                'items' => $data,
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error occurred while processing search request: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while processing the request'], 500);
        }
    }


    public function newsale(Request $request)
    {
        $users = User::all();
        return view('admin.sales.new-sales', [
            'users' => $users,
        ]);
    }

    public function getItem(Request $request)
    {
        if ($request->has('barcode')) {
            $barcode = $request->input('barcode');

            $query = ItemInfo::where('status', 1)
                ->where('approved_status', 1)
                ->where('code', $barcode)
                ->first();

            if ($query) {
                if ($query->current_stock > 0) {
                    return response()->json(['data' => $query, 'message' => 'Item found.', 200]);
                } else {
                    return response()->json(['data' => null, 'message' => 'Item is out of stock.'], 200);
                }
            } else {
                return response()->json(['data' => null, 'message' => 'Item not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Barcode not provided.'], 400);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSellRequest $request)
    {
        set_time_limit(120); // Set the limit to 120 seconds 

        // var_dump($request->all());
        $attribute = $request->validated();

        try {
            DB::beginTransaction();

            $product_id =  $attribute['product_id'];
            $product = ItemInfo::where('id',  $product_id)->first();

            $product = ItemInfo::find($attribute['product_id'][0]);

            $total_due_amount = $attribute['total_payable_amount'] - $attribute['total_payable_amount'];
            $grand_total  =  $attribute['total_payable_amount'] - $attribute['service_charge'];
            $discount  =  $product->discount_amount;
            $tax_amount  =  $product->tax_amount;

            $sell = Sell::create([
                'sells_type' => "pos-sell",
                'sells_status' =>  1,
                'payment_type' => 'Cash',
                'grand_total' => $grand_total,
                'discount' => $discount,
                'payment_details' => 'Sales',
                'service_charge' => $tax_amount,
                'payable' => $attribute['total_payable_amount'],
                'payment_status' => 1,
                'created_by' => Auth::user()->id,
            ]);

            $sell->update([
                'sale_code' => 'SC-' . ($sell->id + 1),
            ]);

            $productIds = $attribute['product_id'];

            foreach ($productIds as $index => $productId) {
                $product = ItemInfo::find($productId);

                $quantity = $attribute['product_qty'][$index];

                $sellitem = SellsItem::create([
                    'store_id' => '1',
                    'sell_id' => $sell->id,
                    'product_id' => $product->id,
                    'published_price' => $product->published_price,
                    'bar_code' => $product->bar_code,
                    'quantity' => $quantity,
                    'sell_price' => $product->sell_price,
                    'discount_amount' => $product->discount_amount,
                    'published_price' => $product->published_price,
                    'sub_total' => $quantity * $product->sell_price,

                ]);
            }


            if ($product) {
                $currentStock = $product->current_stock - $quantity;
                $stockStatus = ($currentStock > 0) ? true : false; // Assuming stock_status is boolean type
                $product->update([
                    'current_stock' => $currentStock,
                    'stock_status' => $stockStatus,
                ]);
            }

            DB::commit();


            return redirect()->route('admin.sales.index');
        } catch (\Exception $error) {
            DB::rollBack();
            Log::error($error);
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sell $sell, Request $request, $id)
    {
        $users = User::all();

        $sell = Sell::select([
            'sells.*'
        ])
            ->where('sells.id', $id)
            ->first();
        $sellItem = SellsItem::select([
            'sells_items.*',
            'item_infos.name as itemname',
            'item_infos.thumbnail as itemthumbnail',
        ])
            ->where('sells_items.sell_id', $id)
            ->leftjoin('item_infos', 'sells_items.product_id', 'item_infos.id')
            ->get();


        return view('admin.sales.sales_details', [
            'sell' => $sell,
            'sellItem' => $sellItem,
        ]);
    }
}
