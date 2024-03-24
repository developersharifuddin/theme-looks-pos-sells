<?php

namespace App\Models;

use Log;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Warranty;
use Milon\Barcode\DNS1D;
use App\Models\SellsItem;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemInfo extends Model
{
    use Filterable;
    protected $guarded = [];

    protected $fillable = [
        'id', 'code', 'name',  'unit',
        'unit_value', 'slug', 'min_qty',
        'weight', 'published_price', 'sell_price',
        'purchase_price', 'discount_type', 'discount_amount', 'tax', 'tax_amount',
        'current_stock', 'thumbnail',
        'published', 'status', 'stock_status',
        'request_status', 'sku',
        'approved',

    ];
    protected $casts = [
        'attachment' => 'array',
    ];


    public function SellsItem()
    {
        return $this->hasMany(SellsItem::class, 'id');
    }
}
