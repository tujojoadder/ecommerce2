<?php

namespace App\Helpers\Traits;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Transaction;

trait InvoiceTrait
{
    public function vat($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        if ($invoice->vat_type == 'percentage') {
            $vat = ($invoice->vat * $invoice->bill_amount) / 100;
            return $vat;
        } else {
            return $invoice->vat;
        }
    }
    public function discount($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $discount = $invoice->total_discount;
        return $discount;
    }

    public function totalBill($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        return $invoice->grand_total;
    }
    public function returnInvoicePayment($invoice_id)
    {
        return Transaction::where('invoice_id', $invoice_id)
            ->whereNull('deleted_at')
            ->where('type', 'return')
            ->sum('amount');
    }
    public function invoicePayment($invoice_id)
    {
        return Transaction::where('invoice_id', $invoice_id)
            ->whereNull('deleted_at')
            ->where('type', 'deposit')
            ->sum('amount');
    }
    public function invoiceDue($invoice_id)
    {
        return $this->totalBill($invoice_id) - $this->invoicePayment($invoice_id);
    }
    public function returnInvoiceDue($invoice_id)
    {
        return $this->totalBill($invoice_id) - $this->returnInvoicePayment($invoice_id);
    }


    // get total sales amount for client_id
    public function ClientTotalSalesAmount($client_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            return Invoice::where('client_id', $client_id)->whereBetween('issued_date', [$start, $end])->sum('bill_amount');
        } else {
            return Invoice::where('client_id', $client_id)->sum('bill_amount');
        }
    }
    // get total bill amount for client_id
    public function ClientTotalBillAmount($client_id, $start = null, $end = null)
    {
        $client = Client::find($client_id);
        if ($client->previous_due > 0) {
            $previous_due = $client->previous_due;
        } else {
            $previous_due = 0;
        }

        if (($start != null) && ($end != null)) {
            $totalBillAmount = Invoice::where('client_id', $client_id)->whereBetween('issued_date', [$start, $end])->sum('grand_total');
            $previous_due = 0;
        } else {
            $totalBillAmount = Invoice::where('client_id', $client_id)->sum('grand_total');
        }

        return $totalBillAmount + $previous_due;
    }
    // get total collection amount for client_id
    public function ClientTotalCollectionAmount($client_id, $start = null, $end = null)
    {
        $client = Client::find($client_id);
        if ($client->previous_due < 0) {
            $previous_due = $client->previous_due;
        } else {
            $previous_due = 0;
        }

        if (($start != null) && ($end != null)) {
            // $totalCollectionAmount = Invoice::where('client_id', $client_id)->whereBetween('issued_date',[$start, $end])->sum('grand_total');
            $totalCollectionAmount = Transaction::whereIn('type', ['deposit', 'previous_due'])->whereIn('transaction_type', ['deposit', 'invoice'])->where('client_id', $client_id)->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            $totalCollectionAmount = Transaction::whereIn('type', ['deposit', 'previous_due'])->whereIn('transaction_type', ['deposit', 'invoice'])->where('client_id', $client_id)->sum('amount');
        }

        return $totalCollectionAmount - ($previous_due);
    }
    // get total client return amount for client_id
    public function ClientTotalReturnAmount($client_id, $start = null, $end = null)
    {
        if (($start != null) && ($end != null)) {
            // $totalCollectionAmount = Invoice::where('client_id', $client_id)->whereBetween('issued_date',[$start, $end])->sum('grand_total');
            return Transaction::where('type', 'cost')->where('transaction_type', 'client_return')->where('client_id', $client_id)->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            return Transaction::where('type', 'cost')->where('transaction_type', 'client_return')->where('client_id', $client_id)->sum('amount');
        }
    }
}
