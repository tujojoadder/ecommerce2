<?php

namespace App\Helpers\Traits;

use App\Models\Account;

trait AccountBalanceTrait
{
    public static function adjustBalance($account_id, $type, $amount, $previousAmount = null)
    {
        $account = Account::findOrFail($account_id);
        if ($previousAmount !== null) {
            if ($type == 'cost') {
                $account->account_debit = $account->account_debit - $previousAmount;

                $account->account_debit = $account->account_debit + $amount;
                $updateBalance = $account->account_balance + $previousAmount;
                $account->account_balance = $updateBalance - $amount;
            }
            if ($type == 'deposit') {
                $account->account_credit = $account->account_credit - $previousAmount;

                $account->account_credit = $account->account_credit + $amount;
                $updateBalance = $account->account_balance - $previousAmount;
                $account->account_balance = $updateBalance + $amount;
            }
            if ($type == 'update-account') {
                $account->account_credit = $account->account_credit - $previousAmount;
                $account->account_credit = $account->account_credit + $amount;

                $account->account_debit = $account->account_debit - $previousAmount;
                $account->account_debit = $account->account_debit + $amount;

                $updateBalance = $account->account_balance - $previousAmount;
                $account->account_balance = $updateBalance + $amount;
            }
        } else {
            if ($type == 'cost') {
                $account->account_debit = $account->account_debit + $amount;
                $account->account_balance = $account->account_balance - $amount;
            }
            if ($type == 'delete-cost') {
                $account->account_debit = $account->account_debit;
                $account->account_credit = $account->account_credit - $amount;
                $account->account_balance = $account->account_balance - $amount;
            }
            if ($type == 'deposit') {
                $account->account_credit = $account->account_credit + $amount;
                $account->account_balance = $account->account_balance + $amount;
            }
        }
        $account->save();
        return $account;
    }
}
