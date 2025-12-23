<?php

namespace App\Helpers;

use App\Helpers\Traits\BalanceTrait;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Transaction;

class ClientBalanceHelper
{
    public static function getClientTotalSales($balanceModel, $client_id)
    {
        $totalSales = $balanceModel::where('deleted_at', null)->where('status', 0)->where('client_id', $client_id)->select('grand_total')->sum('grand_total'); // clients total sales
        return $totalSales;
    }
    public static function getClientTotalBill($balanceModel, $client_id)
    {
        $totalSales = $balanceModel::where('deleted_at', null)->where('status', 0)->where('client_id', $client_id)->select('invoice_bill')->sum('invoice_bill'); // clients total sales
        return $totalSales;
    }
    public static function getClientTotalDeposits($balanceModel, $client_id)
    {
        $totalDeposit = $balanceModel::where('deleted_at', null)->where('client_id', $client_id)->whereNot('transaction_type', 'transfer')->select('amount')->where('type', 'deposit')->sum('amount'); // clients total receives
        return $totalDeposit;
    }
    public static function getClientTotalAdjustment($balanceModel, $client_id)
    {
        $totalAdjustment = $balanceModel::where('deleted_at', null)->where('client_id', $client_id)->whereIn('transaction_type', ['adjustment'])->select('amount')->where('type', 'deposit')->sum('amount'); // clients total receives
        return $totalAdjustment;
    }
    public static function getClientTotalCosts($balanceModel, $client_id)
    {
        $totalCost = $balanceModel::where('deleted_at', null)->where('client_id', $client_id)->select('amount')->where('type', 'cost')->sum('amount'); // clients total receives
        return $totalCost;
    }
    public static function getClientSalesReturn($invoiceModel, $client_id)
    {
        return $invoiceModel::where('deleted_at', null)->where('status', 4)->where('client_id', $client_id)->select('grand_total')->sum('grand_total');
        // return $invoiceModel::where('deleted_at', null)->where('status', 4)->where('client_id', $client_id)->select('receive_amount')->sum('receive_amount');
    }
    public static function getClientTotalMoneyReturn($balanceModel, $client_id)
    {
        $invoiceReturnAmount = $balanceModel::where('deleted_at', null)->select('amount')->where('client_id', $client_id)->whereIn('type', ['return', 'cost'])->whereIn('transaction_type', ['money_return'])->sum('amount'); // total receives
        return $invoiceReturnAmount;
    }
    public static function getClientTotalSalesReturnAdjustment($balanceModel, $client_id)
    {
        $invoiceAdjustmentAmount = $balanceModel::where('deleted_at', null)->where('client_id', $client_id)->where('transaction_type', 'invoice-return')->sum('current_due'); // current due is adjustment amount in this row
        return $invoiceAdjustmentAmount;
    }
    public static function getClientTotalDue($balanceModel, $client_id)
    {
        $client = Client::findOrFail($client_id);
        $previousDue = $client->previous_due;
        $sales = self::getClientTotalSales(Invoice::class, $client_id);
        $salesReturn = self::getClientSalesReturn(Invoice::class, $client_id);
        $salesReturnAdjustment = self::getClientTotalSalesReturnAdjustment($balanceModel, $client_id);
        $moneyReturn = self::getClientTotalMoneyReturn($balanceModel, $client_id) + $salesReturnAdjustment;
        $deposit = self::getClientTotalDeposits($balanceModel, $client_id);

        $netSales = $sales - $salesReturn;
        $netDue = $netSales - $deposit;
        $due = $netDue + $moneyReturn + $previousDue;
        return $due;
    }
    public static function getClientInvoiceDue($invoiceModel, $transactionModel, $invoice_id)
    {
        $invoice = $invoiceModel::findOrFaiL($invoice_id);
        $totalInvoiceBill = $invoice->grand_total;
        $totalInvoicePayment = $transactionModel::where('deleted_at', null)->where('type', 'deposit')->whereIn('transaction_type', ['invoice', 'deposit'])->where('invoice_id', $invoice_id)->sum('amount');
        $invoiceDue = $totalInvoiceBill - $totalInvoicePayment;
        return $invoiceDue;
    }

    public static function getClientTotalLoanPayment($client_id)
    {
        $totalPayment = Transaction::where('deleted_at', null)->where('client_id', $client_id)->where('transaction_type', 'loan_payment')->select('amount')->sum('amount'); // clients total loan payment
        return $totalPayment;
    }

    public static function getClientTotalLoanReceive($client_id)
    {
        $totalReceive = Transaction::where('deleted_at', null)->where('client_id', $client_id)->where('transaction_type', 'loan_receive')->select('amount')->sum('amount'); // clients total loan receive
        return $totalReceive;
    }

    public static function getClientTotalLoanBalance($client_id)
    {
        $payment = self::getClientTotalLoanPayment($client_id);
        $receive = self::getClientTotalLoanReceive($client_id);

        $balance = $receive - $payment;
        return str_replace(',', '', number_format($balance, 2));
    }
}
