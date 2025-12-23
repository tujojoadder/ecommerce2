<?php

namespace App\Models;

use App\Helpers\Traits\StockTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use HasFactory, SoftDeletes, StockTrait;

    protected $fillable = [
        'purchase_id',
        'issued_date',
        'row_id',
        'product_id',
        'unit_id',
        'description',
        'selling_price',
        'quantity',
        'return_type',
        'free',
        'buying_price',
        'total_buying_price',
        'total_selling_price',
        'wholesale_price',
        'barcode_id',
        'created_by',
        'updated_by',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id', 'id')->withTrashed();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    protected $appends = ['item_wise_stock', 'unit_name'];

    public function getItemWiseStockAttribute()
    {
        return $this->stockIndividual($this->purchase_id, $this->product_id);
    }

    public function getUnitNameAttribute()
    {
        return $this->unit->name ?? '';
    }
}
