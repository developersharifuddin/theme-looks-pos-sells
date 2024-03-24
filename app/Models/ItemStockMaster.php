<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemStockMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'receive_Issue_master_id',
        'tran_type_id',
        'tran_source_type_id',
        'prod_type_id',
        'company_id',
        'branch_id',
        'currency_id',
        'receive_issue_date',
        'opening_bal_date',
        'supplier_id',
        'customer_id',
        'uom_id',
        'issue_for',
        'prod_process',
        'payment_method_id',
        'item_cat_id',
        'challan_number',
        'challan_date',
        'remarks',
    ];
    protected $guarded = [];
}
