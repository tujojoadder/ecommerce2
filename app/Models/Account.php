<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'initial_balance',
        'account_number',
        'contact_person',
        'phone',
        'account_debit',
        'account_credit',
        'account_balance',
        'description',
        'is_deleted',
        'status',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function balance($account_id)
    {
        $transactionModel = Transaction::class;
        $totalCredit = $transactionModel::where('deleted_at', null)->where('account_id', $account_id)->where('type', 'deposit')->sum('amount'); // total amount of deposit
        $totalDebit = $transactionModel::where('deleted_at', null)->where('account_id', $account_id)->where('type', 'cost')->sum('amount'); // total amount of withdraw
        $totalReturn = $transactionModel::where('deleted_at', null)->where('account_id', $account_id)->where('transaction_type', 'money_return')->where('type', 'return')->sum('amount');
        $totalBalance = $totalCredit - ($totalDebit + $totalReturn);
        return $totalBalance;
    }
}
