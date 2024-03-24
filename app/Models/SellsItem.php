<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellsItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'sell_id',
        'product_id',
        'published_price', 'store_id', 'quantity', 'bar_code', 'sell_price', 'published_price',
        'discount_amount',
        'sub_total',
    ];
    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id');
    }
    public function ItemInfo()
    {
        return $this->belongsTo(ItemInfo::class, 'id');
    }
    public function published_price()
    {
        return $this->belongsTo(ItemInfo::class, 'id');
    }
}
