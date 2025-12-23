<?php

namespace App\Helpers\Traits;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Transaction;

trait PurchaseTrait
{
    public function vat($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        if ($purchase->vat_type == 'percentage') {
            $vat = ($purchase->vat * $purchase->bill_amount) / 100;
            return $vat;
        } else {
            return $purchase->vat;
        }
    }
    public function discount($purchase_id)
    {
        if ($purchase_id == 0) {
            return 0;
        } else {
            $purchase = Purchase::find($purchase_id);
            if ($purchase->discount_type == 'percentage') {
                $discount = ($purchase->discount * $purchase->bill_amount) / 100;
                return $discount;
            } else {
                return $purchase->discount;
            }
        }
    }

    public function totalBill($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        return $purchase->grand_total;
    }
    public function purchasePayment($purchase_id)
    {
        return Transaction::where('purchase_id', $purchase_id)
            ->whereNull('deleted_at')
            ->where('type', 'cost')
            ->where(function ($query) {
                $query->where('transaction_type', 'supplier_payment')
                    ->orWhere('transaction_type', 'cost');
            })
            ->sum('amount');
    }
    public function purchaseDue($purchase_id)
    {
        return $this->totalBill($purchase_id) - $this->purchasePayment($purchase_id);
    }


    // get total sales amount for supplier_id
    public function SupplierTotalSalesAmount($supplier_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            return Purchase::where('supplier_id', $supplier_id)->whereBetween('issued_date', [$start, $end])->sum('bill_amount');
        } else {
            return Purchase::where('supplier_id', $supplier_id)->sum('bill_amount');
        }
    }
    // get total bill amount for supplier_id
    public function SupplierTotalBillAmount($supplier_id, $start = null, $end = null)
    {
        $supplier = Supplier::find($supplier_id);
        if ($supplier->previous_due > 0) {
            $previous_due = $supplier->previous_due;
        } else {
            $previous_due = 0;
        }

        if (($start != null) && ($end != null)) {
            $totalBillAmount = Purchase::where('supplier_id', $supplier_id)->whereBetween('issued_date', [$start, $end])->sum('grand_total');
            $previous_due = 0;
        } else {
            $totalBillAmount = Purchase::where('supplier_id', $supplier_id)->sum('grand_total');
        }

        return $totalBillAmount + $previous_due;
    }
    // get total collection amount for supplier_id
    public function SupplierTotalCollectionAmount($supplier_id, $start = null, $end = null)
    {
        $supplier = Supplier::find($supplier_id);
        if ($supplier->previous_due < 0) {
            $previous_due = $supplier->previous_due;
        } else {
            $previous_due = 0;
        }

        if (($start != null) && ($end != null)) {
            // $totalCollectionAmount = Purchase::where('supplier_id', $supplier_id)->whereBetween('issued_date',[$start, $end])->sum('grand_total');
            $totalCollectionAmount = Transaction::whereIn('type', ['deposit', 'previous_due'])->whereIn('transaction_type', ['deposit', 'purchase'])->where('supplier_id', $supplier_id)->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            $totalCollectionAmount = Transaction::whereIn('type', ['deposit', 'previous_due'])->whereIn('transaction_type', ['deposit', 'purchase'])->where('supplier_id', $supplier_id)->sum('amount');
        }

        return $totalCollectionAmount - ($previous_due);
    }
    // get total supplier return amount for supplier_id
    public function SupplierTotalReturnAmount($supplier_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            // $totalCollectionAmount = Purchase::where('supplier_id', $supplier_id)->whereBetween('issued_date',[$start, $end])->sum('grand_total');
            return Transaction::where('type', 'cost')->where('transaction_type', 'supplier_return')->where('supplier_id', $supplier_id)->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            return Transaction::where('type', 'cost')->where('transaction_type', 'supplier_return')->where('supplier_id', $supplier_id)->sum('amount');
        }
    }
}
