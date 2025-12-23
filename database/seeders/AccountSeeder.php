<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = Account::create([
            'title' => 'Cash',
            'initial_balance' => 0,
            'account_number' => 123,
            'contact_person' => 123,
            'phone' => '01900000000',
            'account_debit' => 0,
            'account_credit' => 0,
            'account_balance' => 0,
            'description' => 'Cash Receive Account',
            'created_by' => 'admin',
        ]);

        $transaction = new Transaction();
        $transaction->type = 'deposit';
        $transaction->transaction_type = 'account';
        $transaction->date = date('Y-m-d');
        $transaction->account_id = $account->id;
        $transaction->description = $account->description;
        $transaction->amount = $account->initial_balance ?? 0;
        $transaction->current_balance = $account->initial_balance ?? 0;
        $transaction->current_due = 0;
        $transaction->created_by = 'admin';
        $transaction->save();
    }
}
