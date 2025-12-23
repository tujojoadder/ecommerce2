<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'issued_date',
        'purchased_id',
        'row_id',
        'product_id',
        'description',
        'stock',
        'buying_price',
        'selling_price',
        'selling_type',
        'wholesale_price',
        'quantity',
        'return_type',
        'return_quantity',
        'unit_id',
        'total',
        'deleted_by',
        'created_by',
        'updated_by',
        'status'
    ];

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id', 'id')->withTrashed();
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    protected $appends = ['product_name', 'unit_name'];

    public function getProductNameAttribute()
    {
        return $this->product->name ?? '';
    }
    public function getUnitNameAttribute()
    {
        return $this->unit->name ?? '';
    }
}
