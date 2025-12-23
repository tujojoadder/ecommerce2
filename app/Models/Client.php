<?php

namespace App\Models;

use App\Helpers\ClientBalanceHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_no',
        'client_name',
        'fathers_name',
        'mothers_name',
        'company_name',
        'address',
        'phone',
        'phone_optional',
        'previous_due',

        'sales',
        'sales_return',
        'receive',
        'money_return',
        'sales_return_adjustment',
        'adjustment',
        'due',

        'max_due_limit',
        'email',
        'date_of_birth',
        'upazilla_thana',
        'street_road',
        'reference',
        'zip_code',
        'image',
        'group_id',
        'is_deleted',
        'type',
        'status',
        'created_by',
    ];

    public function group()
    {
        return $this->belongsTo(ClientGroup::class, 'group_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id', 'id');
    }

    public function totalReceive()
    {
        return $this->hasMany(Transaction::class, 'client_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'client_id', 'id');
    }

    public function hasDueOrNot($client_id)
    {
        $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $client_id);
        if ($clientDue <= 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function totalDue()
    {
        $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $this->id);
        return $clientDue;
    }

    // protected $appends = ['total_sale', 'total_sales_return', 'total_sales_return_adjustment', 'total_money_return', 'total_deposit', 'total_bill', 'total_due', 'group_name', 'total_adjustment'];
    public function getTotalSaleAttribute()
    {
        return ClientBalanceHelper::getClientTotalSales(Invoice::class, $this->id);
    }
    public function getTotalSalesReturnAttribute()
    {
        return ClientBalanceHelper::getClientSalesReturn(Invoice::class, $this->id);
    }
    public function getTotalSalesReturnAdjustmentAttribute()
    {
        return ClientBalanceHelper::getClientTotalSalesReturnAdjustment(Transaction::class, $this->id);
    }
    public function getTotalBillAttribute()
    {
        return ClientBalanceHelper::getClientTotalBill(Invoice::class, $this->id);
    }
    public function getTotalDueAttribute()
    {
        return ClientBalanceHelper::getClientTotalDue(Transaction::class, $this->id);
    }
    public function getTotalDepositAttribute()
    {
        return ClientBalanceHelper::getClientTotalDeposits(Transaction::class, $this->id);
    }
    public function getTotalMoneyReturnAttribute()
    {
        return ClientBalanceHelper::getClientTotalMoneyReturn(Transaction::class, $this->id);
    }
    public function getTotalAdjustmentAttribute()
    {
        return ClientBalanceHelper::getClientTotalAdjustment(Transaction::class, $this->id);
    }
    public function getGroupNameAttribute()
    {
        return $this->group->name ?? '';
    }
}
