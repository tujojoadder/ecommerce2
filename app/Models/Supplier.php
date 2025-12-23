<?php

namespace App\Models;

use App\Helpers\SupplierBalanceHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'company_name',
        'phone',
        'phone_optional',
        'email',

        'previous_due',
        'purchase',
        'purchase_return',
        'payment',
        'receive',
        'adjustment',
        'due',

        'address',
        'city_state',
        'zip_code',
        'country_name',
        'domain',
        'bank_account',
        'image',
        'group_id',
        'status',
    ];

    public function group()
    {
        return $this->belongsTo(SupplierGroup::class, 'group_id', 'id');
    }

    public function purchases()
    {
        return $this->belongsTo(Purchase::class, 'supplier_id', 'id');
    }

    public function supplierDue()
    {
        return SupplierBalanceHelper::getTotalDue(Transaction::class, $this->id);
    }

    // protected $appends = [
    //     'supplier_due',
    //     'purchase',
    //     'purchase_return',
    //     'payment',
    //     'receive',
    //     'adjustment',
    // ];
    public function getTotalSupplierDueAttribute()
    {
        return SupplierBalanceHelper::getTotalDue(Transaction::class, $this->id);
    }
    public function getTotalPurchaseAttribute()
    {
        return SupplierBalanceHelper::getTotalSales(Purchase::class, $this->id);
    }
    public function getTotalPurchaseReturnAttribute()
    {
        return SupplierBalanceHelper::getTotalSalesReturn(Purchase::class, $this->id);
    }
    public function getTotalPaymentAttribute()
    {
        return SupplierBalanceHelper::getSupplierPayments(Transaction::class, $this->id);
    }
    public function getTotalReceiveAttribute()
    {
        return SupplierBalanceHelper::getSupplierReceive(Transaction::class, $this->id);
    }
    public function getTotalAdjustmentAttribute()
    {
        return SupplierBalanceHelper::getTotalSalesReturnDiscount(Purchase::class, $this->id);
    }

}
