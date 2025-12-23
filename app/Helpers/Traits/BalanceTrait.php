<?php

namespace App\Helpers\Traits;

use App\Helpers\BalanceHelper as Balance;
use App\Helpers\ClientBalanceHelper as ClientBalance;
use App\Helpers\SupplierBalanceHelper as SupplierBalance;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\SiteSetting;
use App\Models\Transaction;
use Carbon\Carbon;

trait BalanceTrait
{
    public function allWallets()
    {
        $invoice = Invoice::class;
        $transaction = Transaction::class;

        $wallet['balance'] = round(Balance::getCurrentBalance($transaction), 2);
        $wallet['total_purchase'] = round(Balance::getTotalPurchase(), 2);
        $wallet['total_sales'] = round(Balance::getTotalSales(), 2);
        $wallet['total_deposit'] = round(Balance::getTotalDeposits($transaction), 2);
        $wallet['total_cost'] = round(Balance::getTotalCosts($transaction), 2);
        $wallet['total_return'] = round(Balance::getTotalMoneyReturn($transaction), 2);
        $wallet['total_due'] = round(Balance::getTotalDue($transaction), 2);
        $wallet['total_client_due'] = round(Balance::totalClientDue(), 2);
        $wallet['total_client_advance'] = round(Balance::totalClientAdvance(), 2);
        $wallet['total_previous_due'] = round(Balance::getTotalPreviousDue(), 2);
        $wallet['total_stock_value'] = round(Balance::getTotalStockValue(), 2);

        $wallet['today_balance'] = round(Balance::getTodayBalance($transaction), 2);
        $wallet['today_sales'] = number_format(round(Balance::getTodaySales($invoice), 2), 2);
        $wallet['today_deposit'] = number_format(round(Balance::getTodayDeposits($transaction), 2), 2);
        $wallet['today_cost'] = number_format(round(Balance::getTodayCosts($transaction), 2), 2);
        $wallet['today_return'] = number_format(round(Balance::getTodayReturn($transaction), 2), 2);
        $wallet['today_due'] = number_format(round(Balance::getTodayDue($transaction), 2), 2);

        $wallet['monthly_balance'] = round(Balance::getMonthlyBalance($transaction), 2);
        $wallet['monthly_sales'] = number_format(round(Balance::getMonthlySales($invoice), 2), 2);
        $wallet['monthly_deposit'] = number_format(round(Balance::getMonthlyDeposits($transaction), 2), 2);
        $wallet['monthly_cost'] = number_format(round(Balance::getMonthlyCosts($transaction), 2), 2);
        $wallet['monthly_return'] = number_format(round(Balance::getMonthlyReturn($transaction), 2), 2);
        $wallet['monthly_due'] = number_format(round(Balance::getMonthlyDue($transaction), 2), 2);
        return $wallet;
    }

    public function getWalletNames()
    {
        $wallet_names['balnace_name'] = 'Balance';
        $wallet_names['total_purchase_name'] = 'Total Purchase';
        $wallet_names['total_sales_name'] = 'Total Sales';
        $wallet_names['total_deposit_name'] = 'Total Deposit';
        $wallet_names['total_cost_name'] = 'Total Expense';
        $wallet_names['total_due_name'] = 'Total Balance';

        $wallet_names['today_balance_name'] = 'Today Sales';
        $wallet_names['today_sales_name'] = 'Today Sales';
        $wallet_names['today_deposit_name'] = 'Today Receive';
        $wallet_names['today_cost_name'] = 'Today Expense';
        $wallet_names['today_due_name'] = 'Today Balance';

        $settings = SiteSetting::first();
        $carbon = Carbon::class;

        $language = $settings->language ?? 'en';
        if ($language == 'bn') {
            $monthNames = ['January' => 'জানুয়ারি', 'February' => 'ফেব্রুয়ারি', 'March' => 'মার্চ', 'April' => 'এপ্রিল', 'May' => 'মে', 'June' => 'জুন', 'July' => 'জুলাই', 'August' => 'অগাস্ট', 'September' => 'সেপ্টেম্বর', 'October' => 'অক্টোবর', 'November' => 'নভেম্বর', 'December' => 'ডিসেম্বর'];
        } else {
            $monthNames = ['January' => 'January', 'February' => 'February', 'March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December'];
        }
        $months = $carbon::now()->format('F');
        $month = $monthNames[$months] ?? 'Invalid month';

        $wallet_names['monthly_balance_name'] = $month;
        $wallet_names['monthly_sales_name'] = $month;
        $wallet_names['monthly_deposit_name'] = $month;
        $wallet_names['monthly_cost_name'] = $month;
        $wallet_names['monthly_due_name'] = $month;

        return $wallet_names;
    }

    public function getWalletLinks()
    {
        $wallet_names['total_sales'] = route('user.report.sales.index');
        $wallet_names['total_deposit'] = route('user.report.deposit.all');
        $wallet_names['total_cost'] = route('user.report.expense.all');
        $wallet_names['total_due'] = 'javascript:;';

        $wallet_names['today_sales'] = 'javascript:;';
        $wallet_names['today_deposit'] = 'javascript:;';
        $wallet_names['today_cost'] = 'javascript:;';
        $wallet_names['today_due'] = 'javascript:;';

        $wallet_names['monthly_sales'] = 'javascript:;';
        $wallet_names['monthly_deposit'] = 'javascript:;';
        $wallet_names['monthly_cost'] = 'javascript:;';
        $wallet_names['monthly_due'] = 'javascript:;';
        return $wallet_names;
    }


    public function clientWallets($client_id)
    {
        $invoice = Invoice::class;
        $transaction = Transaction::class;
        $wallet['client_total_sales'] = round(ClientBalance::getClientTotalSales($invoice, $client_id), 2);
        $wallet['client_total_bill'] = round(ClientBalance::getClientTotalBill($invoice, $client_id), 2);
        $wallet['client_total_deposit'] = round(ClientBalance::getClientTotalDeposits($transaction, $client_id), 2);
        $wallet['client_total_sales_return'] = round(ClientBalance::getClientSalesReturn($invoice, $client_id), 2);
        $wallet['client_total_sales_return_adjustment'] = round(ClientBalance::getClientTotalSalesReturnAdjustment($transaction, $client_id), 2);
        $wallet['client_total_money_return'] = round(ClientBalance::getClientTotalMoneyReturn($transaction, $client_id), 2);
        $wallet['client_total_cost'] = round(ClientBalance::getClientTotalCosts($transaction, $client_id), 2);
        $wallet['client_total_due'] = round(ClientBalance::getClientTotalDue($transaction, $client_id), 2);
        $wallet['client_total_adjustment'] = round(ClientBalance::getClientTotalAdjustment($transaction, $client_id), 2);
        return $wallet;
    }

    public function getClientWalletNames()
    {
        $wallet_names['client_total_sales'] = 'Total Sales';
        $wallet_names['client_total_deposit'] = 'Total Deposit';
        $wallet_names['client_total_return'] = 'Total Return';
        $wallet_names['client_total_cost'] = 'Total Expense';
        $wallet_names['client_total_due'] = 'Total Balance';
        return $wallet_names;
    }

    public function getClientWalletLinks($client_id)
    {
        $wallet_links['client_total_sales'] = route('user.report.sales.index') . '?' . $client_id;
        $wallet_links['client_total_deposit'] = route('user.report.deposit.all') . '?' . $client_id;
        $wallet_links['client_total_cost'] = route('user.report.expense.all') . '?' . $client_id;
        $wallet_links['client_total_due'] = 'javascript:;' . '?' . $client_id;
        return $wallet_links;
    }

    public function invoiceDue($invoice_id)
    {
        $invoiceModel = Invoice::class;
        $transactionModel = Transaction::class;
        $wallet['client_invoice_due'] = round(ClientBalance::getClientInvoiceDue($invoiceModel, $transactionModel, $invoice_id), 2);
        return $wallet;
    }

    // --------------------- Suppliers ---------------------
    public function supplierWallets($supplier_id)
    {
        $purchase = Purchase::class;
        $transaction = Transaction::class;
        $wallet['supplier_total_sales'] = round(SupplierBalance::getTotalSales($purchase, $supplier_id), 2);
        $wallet['supplier_total_sales_return'] = round(SupplierBalance::getTotalSalesReturn($purchase, $supplier_id), 2);
        $wallet['supplier_total_deposit'] = round(SupplierBalance::getTotalDeposits($transaction, $supplier_id), 2);
        $wallet['supplier_total_payment'] = round(SupplierBalance::getSupplierPayments($transaction, $supplier_id), 2);
        $wallet['supplier_total_cost'] = round(SupplierBalance::getTotalCosts($transaction, $supplier_id), 2);
        $wallet['supplier_total_due'] = round(SupplierBalance::getTotalDue($transaction, $supplier_id), 2);
        $wallet['supplier_money_received'] = round(SupplierBalance::getSupplierReceive($transaction, $supplier_id), 2);
        $wallet['supplier_sales_return_discount'] = round(SupplierBalance::getTotalSalesReturnDiscount($purchase, $supplier_id), 2);
        return $wallet;
    }

    public function getSupplierWalletNames()
    {
        $wallet_names['supplier_total_sales'] = 'Total Sales';
        $wallet_names['supplier_total_sales_return'] = 'Total Sales Return';
        $wallet_names['supplier_total_deposit'] = 'Total Deposit';
        $wallet_names['supplier_total_payment'] = 'Total Return';
        $wallet_names['supplier_total_cost'] = 'Total Expense';
        $wallet_names['supplier_total_due'] = 'Total Balance';
        return $wallet_names;
    }

    public function getSupplierWalletLinks($supplier_id)
    {
        $wallet_links['supplier_total_sales'] = route('user.report.sales.index') . '?' . $supplier_id;
        $wallet_links['supplier_total_sales_return'] = route('user.report.sales.index') . '?' . $supplier_id;
        $wallet_links['supplier_total_deposit'] = route('user.report.deposit.all') . '?' . $supplier_id;
        $wallet_links['supplier_total_payment'] = 'javascript:;';
        $wallet_links['supplier_total_cost'] = route('user.report.expense.all') . '?' . $supplier_id;
        $wallet_links['supplier_total_due'] = 'javascript:;' . '?' . $supplier_id;
        return $wallet_links;
    }

    public function purchaseDue($purchase_id)
    {
        $purchaseModel = Purchase::class;
        $transactionModel = Transaction::class;
        $wallet['supplier_purchase_due'] = round(SupplierBalance::getPurchaseDue($purchaseModel, $transactionModel, $purchase_id), 2);
        return $wallet;
    }
}
