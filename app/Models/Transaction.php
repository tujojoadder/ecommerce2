<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'transaction_type',
        'expense_type',
        'client_id',
        'supplier_id',
        'invoice_id',
        'transfer_id',
        'purchase_id',
        'date',
        'account_id',
        'description',
        'amount',
        'current_due',
        'current_balance',
        'project_id',
        'chart_account_id',
        'chart_group_id',
        'category_id',
        'subcategory_id',
        'payment_id',
        'bank_id',
        'cheque_no',
        'send_sms',
        'send_email',
        'image',
        'tags',
        'reference',

        'created_by',
        'updated_by',
        'deleted_by',
        'is_deleted',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id', 'id');
    }

    public function receiveCategory()
    {
        return $this->belongsTo(ReceiveCategory::class, 'category_id', 'id');
    }
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}
