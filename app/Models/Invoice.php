<?php

namespace App\Models;

use App\Helpers\Traits\InvoiceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes, InvoiceTrait;
    protected $fillable = [
        'id',
        'client_id',
        'track_number',
        'issued_date',
        'discount_type',
        'discount',
        'transport_fare',
        'labour_cost',
        'account_id',

        'bank_id',
        'cheque_number',
        'cheque_issued_date',

        'category_id',
        'receive_amount',
        'cash_receive',
        'change_amount',
        'bill_amount',
        'due_amount',
        'highest_due',
        'vat_type',
        'vat',
        'description',
        'warranty',

        'total_discount',
        'invoice_bill',
        'previous_due',
        'due_before_return',
        'total_vat',
        'grand_total',
        'total_due',
        'adjusting_amount',

        'created_by',
        'send_sms',
        'send_email',
        'status',
        'total_shipping_charge',
        'order_id',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function category()
    {
        return $this->belongsTo(ReceiveCategory::class)->withTrashed();
    }

    public function returnAmount($id)
    {
        $invoice = self::findOrFail($id);
        $returnAmount = $invoice->invoiceItems
            ->where(function ($item) {
                return $item->return_quantity !== null && $item->return_quantity !== 0;
            })
            ->sum(function ($item) {
                return $item->selling_price * $item->return_quantity;
            });

        return $returnAmount;
    }

    public function billAmount($id)
    {
        $invoice = self::findOrFail($id);
        $billAmount = $invoice->invoiceItems
            ->sum(function ($item) {
                return $item->selling_price * $item->quantity;
            });

        return $billAmount;
    }

    protected $appends = ['invoice_due', 'invoice_receive', 'client_name', 'client_phone', 'account_title', 'category_name'];

    public function getInvoiceDueAttribute()
    {
        return $this->invoiceDue($this->id);
    }

    public function getInvoiceReceiveAttribute()
    {
        return $this->invoicePayment($this->id);
    }

    public function getClientNameAttribute()
    {
        return $this->client->client_name ?? '';
    }

    public function getClientPhoneAttribute()
    {
        return $this->client->phone ?? '';
    }

    public function getAccountTitleAttribute()
    {
        return $this->account->title ?? '';
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->title ?? '';
    }
}
