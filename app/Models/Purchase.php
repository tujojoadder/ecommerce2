<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'supplier_id',
        'stock_id',
        'warehouse_id',
        'issued_date',
        'discount_type',
        'discount',
        'transport_fare',
        'vat_type',
        'vat',
        'account_id',
        'category_id',
        'receive_amount',
        'bill_amount',
        'due_amount',
        'invoice_bill',
        'total_vat',
        'total_discount',
        'grand_total',
        'total_due',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_deleted',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id')->withTrashed();
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'purchase_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function returnAmount($id)
    {
        $purchase = self::findOrFail($id);
        $returnAmount = $purchase->purchaseItems
            ->where(function ($item) {
                return $item->return_quantity !== null && $item->return_quantity !== 0;
            })
            ->sum(function ($item) {
                return $item->buying_price * $item->return_quantity;
            });

        return $returnAmount;
    }

    public function billAmount($id)
    {
        $purchase = self::findOrFail($id);
        $billAmount = $purchase->purchaseItems->sum(function ($item) {
            return $item->buying_price * $item->quantity;
        });

        return $billAmount;
    }

    protected $appends = ['supplier_name'];

    public function getSupplierNameAttribute()
    {
        return $this->supplier->supplier_name ?? '';
    }
}
