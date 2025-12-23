<?php

namespace App\Http\Controllers\User;

use App\Helpers\BalanceHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function index()
    {
        if (request()->starting_date && request()->ending_date) {
            // Total Sales
            $searchDate = [enSearchDate(request()->starting_date, request()->ending_date)];
            $totalSales = BalanceHelper::getTotalSales($searchDate);
            $totalPurchasePrice = BalanceHelper::getTotalPurchase($searchDate);

            // Total deposit
            $totalReceive = BalanceHelper::getTotalDeposits(Transaction::class, $searchDate);

            // Total buy price
            $totalBuyPrice = BalanceHelper::getTotalBuyPrice(Invoice::class, $searchDate);

            // Total total due
            $totalDue = BalanceHelper::getTotalDue(Transaction::class, $searchDate);

            // Total personal cost
            $totalPersonalExpense = BalanceHelper::getTotalPersonalCosts(Transaction::class, $searchDate);
            $totalSupplierPayment = BalanceHelper::totalSupplierPayment($searchDate);
            $totalExpense = BalanceHelper::getTotalCosts(Transaction::class, $searchDate) - $totalPersonalExpense - $totalSupplierPayment;
            $totalMoneyReturn = BalanceHelper::getTotalMoneyReturn(Transaction::class, $searchDate);

            // Total office expense
            // $totalExpense = BalanceHelper::getTotalOfficeExpense(Transaction::class, $searchDate);

            // Total current balance
            $totalBalance = BalanceHelper::getCurrentBalance(Transaction::class, $searchDate);
            $totalPreviousDue = BalanceHelper::getTotalPreviousDue($searchDate);
            $totalDiscount = Invoice::whereBetween('issued_date', $searchDate)->where('status', 0)->sum('discount');
            $totalTransportFare = BalanceHelper::getTotalTransportFare($searchDate);
            $totalVat = BalanceHelper::getTotalVat($searchDate);
            $openingBalance = Transaction::where('transaction_type', 'account')->whereBetween('date', $searchDate)->sum('amount');
        } else {
            // Total Sales
            $totalSales = BalanceHelper::getTotalSales();
            $totalPurchasePrice = BalanceHelper::getTotalPurchase();

            // Total deposit
            $totalReceive = BalanceHelper::getTotalDeposits(Transaction::class);

            // Total buy price
            $totalBuyPrice = BalanceHelper::getTotalBuyPrice(Invoice::class);

            // Total total due
            $totalDue = BalanceHelper::getTotalDue(Transaction::class);

            // Total personal cost
            $totalPersonalExpense = BalanceHelper::getTotalPersonalCosts(Transaction::class);
            $totalSupplierPayment = BalanceHelper::totalSupplierPayment();
            $totalExpense = BalanceHelper::getTotalCosts(Transaction::class) - $totalPersonalExpense - $totalSupplierPayment;
            $totalMoneyReturn = BalanceHelper::getTotalMoneyReturn(Transaction::class);

            // Total office expense
            // $totalExpense = BalanceHelper::getTotalOfficeExpense(Transaction::class);

            // Total current balance
            $totalBalance = BalanceHelper::getCurrentBalance(Transaction::class);
            $totalPreviousDue = BalanceHelper::getTotalPreviousDue();
            $totalDiscount = Invoice::where('status', 0)->sum('discount');
            $totalTransportFare = BalanceHelper::getTotalTransportFare();
            $totalVat = BalanceHelper::getTotalVat();
            $openingBalance = Transaction::where('transaction_type', 'account')->sum('amount');
        }
        $otherBill = $totalTransportFare + $totalVat;
        $pageTitle = __('messages.profit');
        return view('user.profit.index', compact('pageTitle', 'totalSales', 'otherBill', 'totalVat', 'totalPersonalExpense', 'totalPurchasePrice', 'totalSupplierPayment', 'totalReceive', 'totalDue', 'totalExpense', 'totalBalance', 'totalBuyPrice', 'totalDiscount', 'openingBalance', 'totalPreviousDue', 'totalMoneyReturn'));
    }

    public function totalBalanceReport()
    {
        $pageTitle = __('messages.total_balance_report');

        $selfInvestment = BalanceHelper::selfInvestment();
        $totalSupplierPurchase = BalanceHelper::totalSupplierPurchase();
        $totalSupplierDue = BalanceHelper::totalSupplierDue();
        $totalSupplierPayment = BalanceHelper::totalSupplierPayment();
        $totalLoanAmount = BalanceHelper::totalLoanAmount();
        $totalClientAdvance = BalanceHelper::totalClientAdvance();
        $totalRunningCapital = BalanceHelper::totalRunningCapital();

        return view('user.profit.balance', compact('pageTitle', 'totalSupplierDue', 'totalSupplierPayment', 'totalSupplierPurchase', 'selfInvestment', 'totalLoanAmount', 'totalClientAdvance', 'totalRunningCapital'));
    }
}
