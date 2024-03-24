<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\SellsItem;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sell extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [''];

    protected $fillable = [
        'id', 'sells_status', 'created_by', 'payment_type', 'payment_status',
        'payable', 'sale_code', 'payment_details', 'service_charge',
        'discount', 'grand_total', 'sells_type'
    ];

    public function sellsItems()
    {
        return $this->hasMany(SellsItem::class, 'sell_id');
    }



    public function hasPagination($query, $request)
    {
        return $query->paginate($request->input('per_page', 10));
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->where('id', 'like', "%$search%")
                ->orWhere('customer_id', 'like', "%$search%");
        });

        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->where('customer_id', 'like', '%' . $search . '%');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
