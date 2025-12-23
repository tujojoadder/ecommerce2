<?php

namespace App\Helpers\Traits;

use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\PurchaseItem;
use Carbon\Carbon;

trait StockTrait
{
    public static function stock($product_id = null, $dates = null)
    {
        try {
            $product = Product::findOrFail($product_id) ?? [];
            $totalPurchased = PurchaseItem::where('product_id', $product_id);
            if ($dates) {
                $totalPurchased->whereBetween('issued_date', $dates);
            }
            $purchasedTotalQuantity = (clone $totalPurchased)->where('status', 0)->sum('quantity');
            $purchasedTotalReturnQuantity = $totalPurchased->where('status', 4)->sum('quantity');

            // Invoice Count
            $totalSales = InvoiceItem::where('product_id', $product_id);
            if ($dates) {
                $totalSales->whereBetween('issued_date', $dates);
            }
            $invoiceTotalQuantity = (clone $totalSales)->where('status', 0)->sum('quantity');
            $invoiceReturnQuantity = $totalSales->where('status', 4)->sum('quantity');
            // Invoice Count

            $in = $purchasedTotalQuantity + $invoiceReturnQuantity + $product->opening_stock;
            $out = $purchasedTotalReturnQuantity + $invoiceTotalQuantity;
            return $in - $out;
        } catch (\Throwable $th) {
        }
    }

    public static function stockIndividual($purchase_id, $product_id = null, $dates = null)
    {
        $totalPurchased = PurchaseItem::where('purchase_id', $purchase_id)->where('product_id', $product_id);
        if ($dates) {
            $totalPurchased->whereBetween('issued_date', $dates);
        }
        $purchasedTotalQuantity = $totalPurchased->where('status', 0)->sum('quantity');
        $purchasedTotalReturnQuantity = $totalPurchased->where('status', 4)->sum('quantity');

        // Invoice Count
        $totalSales = InvoiceItem::where('purchased_id', $purchase_id)->where('product_id', $product_id)->select('quantity');
        if ($dates) {
            $totalSales->whereBetween('issued_date', $dates);
        }
        $invoiceSalesQuantity = (clone $totalSales)->where('status', 0)->sum('quantity');
        $invoiceReturnQuantity = $totalSales->where('status', 4)->sum('quantity');
        // Invoice Count

        $in = $purchasedTotalQuantity + $invoiceReturnQuantity;
        $out = $invoiceSalesQuantity + $purchasedTotalReturnQuantity;
        return $in - $out;
    }

    public static function stockOpening($product_id = null, $dates = null)
    {
        // Invoice Count
        $product = Product::findOrFail($product_id);
        $totalSalesQty = InvoiceItem::where('product_id', $product_id)->select('quantity');
        if ($dates) {
            $totalSalesQty->whereBetween('issued_date', $dates);
        }
        $salesQty = $totalSalesQty->sum('quantity');
        return $product->opening_stock - $salesQty;
    }

    public static function prevStock($product_id = null, $date = null, $openingStock = null)
    {
        if ($date != null) {
            $startDate = bnToEnDate(request()->starting_date, null, 1);
            $purchase = PurchaseItem::whereDate('issued_date', '<=', $startDate)->whereDate('issued_date', '<=', $startDate);
            $totalPurchase = (clone $purchase)->where('status', 0)->sum('quantity');
            $purchaseReturn = $purchase->where('status', 4)->sum('quantity');

            $sales = InvoiceItem::with('product')->where('product_id', $product_id)->whereDate('issued_date', '<=', $startDate);
            $totalSales = (clone $sales)->where('status', 0)->sum('quantity');
            $salesReturn = $sales->where('status', 4)->sum('quantity');

            return (($totalPurchase - $purchaseReturn) + $openingStock + $salesReturn) - $totalSales;
        } else {
            return 0;
        }
    }

    public static function buyQuantity($product, $dates = null)
    {
        if ($dates != null) {
            $total = $product->purchases->where('status', 0)->whereBetween('issued_date', $dates)->sum('quantity');
            $return = $product->purchases->where('status', 4)->whereBetween('issued_date', $dates)->sum('quantity');
        } else {
            $total = $product->purchases->where('status', 0)->sum('quantity');
            $return = $product->purchases->where('status', 4)->sum('quantity');
        }

        return $total - $return;
    }

    public static function saleQuantity($row, $dates = null)
    {
        if ($dates != null) {
            $totalSale = $row->invoices->where('status', 0)->whereBetween('issued_date', $dates)->sum('quantity');
            $totalReturn = $row->invoices->where('status', 4)->whereBetween('issued_date', $dates)->sum('quantity');
            return $totalSale - $totalReturn;
        } else {
            $sale = $row->invoices->where('status', 0)->sum('quantity');
            $return = $row->invoices->where('status', 4)->sum('quantity');
        }
        return $sale;
    }

    public static function returnQuantity($row, $dates = null)
    {
        if ($dates != null) {
            $totalReturn = $row->invoices->where('status', 4)->whereBetween('issued_date', $dates)->sum('quantity');
            return $totalReturn;
        } else {
            $return = $row->invoices->where('status', 4)->sum('quantity');
        }
        return $return;
    }
}
