<?php

namespace App\Helpers\Traits;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait ProductTrait
{
    // buy trait
    public function buyTotalAmount($product_id)
    {
        // return InvoiceItem::where('product_id', $product_id)->sum(DB::raw('quantity - (free + return_qty)'));

        return 0;
    }

    // sales trait
    public function saleQty($product_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            $first = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');
            $last = Carbon::createFromFormat('d/m/Y', $end)->addDay()->format('Y-m-d');

            return InvoiceItem::where('product_id', $product_id)->whereBetween('created_at', [$first, $last])->sum('quantity');
        } else {
            return InvoiceItem::where('product_id', $product_id)->sum('quantity');
        }
    }
    public function returnQty($product_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            $first = Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d H:i:s');
            $last = Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d H:i:s');

            return InvoiceItem::where('product_id', $product_id)->whereBetween('created_at', [$first, $last])->sum('quantity');
        } else {
            return InvoiceItem::where('product_id', $product_id)->sum('quantity');
        }
    }
}
