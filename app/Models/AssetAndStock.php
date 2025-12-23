<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAndStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_type',
        'date',
        'supplier_id',
        'product_id',
        'unit',
        'quantity',
        'rate',
        'total_amount',
        'account',
        'category',
        'chart_of_account_id',
        'chart_of_account_group_id',
        'voucher_no',
        'id_no',
        'description',
        'type',
    ];
}
