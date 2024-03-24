<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemStockChild extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemstock_master_id',
        'receive_issue_child_id',
        'store_id',
        'opening_bal_qty',
        'opening_bal_rate',
        'opening_bal_amount',
        'receive_qty',
        'receive_rate',
        'receive_amount',
        'issue_qty',
        'issue_rate',
        'issue_amount',
        'closing_bal_qty',
        'closing_bal_rate',
        'closing_bal_amount',
        'created_by',
        'updated_by'
    ];

    protected $guarded = [];
}
