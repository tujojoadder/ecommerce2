<?php

namespace App\Helpers;

use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;

class SupplierBalanceHelper
{
    public static function getTotalSales($purchaseModel, $supplier_id)
    {
        $totalSales = $purchaseModel::where('supplier_id', $supplier_id)->where('status', 0)->select('grand_total')->sum('grand_total'); // suppliers total sales
        return $totalSales;
    }
    public static function getTotalSalesReturn($purchaseModel, $supplier_id)
    {
        $totalReeturn = $purchaseModel::where('supplier_id', $supplier_id)->where('status', 4)->select('grand_total')->sum('grand_total'); // suppliers total sales
        return $totalReeturn;
    }
    public static function getTotalSalesReturnDiscount($purchaseModel, $supplier_id)
    {
        $totalReeturn = $purchaseModel::where('supplier_id', $supplier_id)->where('status', 4)->select('total_discount')->sum('total_discount'); // suppliers total sales
        return $totalReeturn;
    }
    public static function getTotalDeposits($balanceModel, $supplier_id)
    {
        $totalDeposit = $balanceModel::where('supplier_id', $supplier_id)->select('amount')->where('type', 'deposit')->sum('amount'); // suppliers total receives
        return 0; //$totalDeposit;
    }
    public static function getSupplierPayments($balanceModel, $supplier_id)
    {
        $totalMoneyReturn = $balanceModel::whereIn('transaction_type', ['supplier_payment', 'purchase'])->where('supplier_id', $supplier_id)->select('amount')->where('type', 'cost')->sum('amount'); // suppliers total return
        return $totalMoneyReturn;
    }
    public static function getSupplierReceive($balanceModel, $supplier_id)
    {
        $supplierReceive = $balanceModel::whereIn('transaction_type', ['purchase_return', 'supplier_receive'])->where('supplier_id', $supplier_id)->select('amount')->sum('amount'); // suppliers total return
        return $supplierReceive;
    }
    public static function getTotalCosts($balanceModel, $supplier_id)
    {
        $totalCost = $balanceModel::where('supplier_id', $supplier_id)->select('amount')->where('type', 'cost')->sum('amount'); // suppliers total receives
        return $totalCost;
    }
    public static function getTotalDue($balanceModel, $supplier_id)
    {
        $previousDue = Supplier::findOrFail($supplier_id)->previous_due;
        $totalSales = (self::getTotalSales(Purchase::class, $supplier_id) - self::getTotalSalesReturn(Purchase::class, $supplier_id)) + $previousDue; // suppliers total sales
        $totalSalesReturn = self::getSupplierReceive(Transaction::class, $supplier_id);
        $totalPayment = $balanceModel::where('supplier_id', $supplier_id)->select('amount')->whereIn('transaction_type', ['supplier_payment', 'purchase'])->where('type', 'cost')->sum('amount'); // suppliers total receives
        $totalDue = $totalSales - $totalPayment + $totalSalesReturn;
        return $totalDue;
    }
    public static function getPurchaseDue($purchaseModel, $transactionModel, $purchase_id)
    {
        $purchase = $purchaseModel::findOrFaiL($purchase_id);
        $totalInvoiceBill = $purchase->grand_total;
        $totalPurchasePayment = $transactionModel::where('type', 'deposit')->where('transaction_type', 'purchase')->where('purchase_id', $purchase_id)->sum('amount');
        $purchaseDue = $totalInvoiceBill - $totalPurchasePayment;
        return $purchaseDue;
    }
}
