<?php

namespace App\Http\Controllers\User\Invoices;

use App\DataTables\InvoiceDataTable;
use App\DataTables\SalesReturnDataTable;
use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\Traits\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Mail\InvoiceMail;
use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Models\InvoiceItem;
use App\Models\PurchaseItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Jorenvh\Share\ShareFacade;

class InvoiceController extends Controller
{
    use DeleteLogTrait, AccountBalanceTrait, InvoiceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceDataTable $dataTable)
    {
        if (request()->has('draft')) {
            $pageTitle = __('messages.draft') . ' ' . __('messages.invoice') . ' ' . __('messages.list');
        } else {
            $pageTitle = __('messages.invoice') . ' ' . __('messages.list');
        }
        return $dataTable->render('user.invoice.index', compact('pageTitle'));
    }
    public function salesReturn(SalesReturnDataTable $dataTable)
    {
        if (request()->routeIs('user.invoice.create.draft')) {
            $pageTitle = __('messages.add') . ' ' . __('messages.draft');
        } elseif (request()->routeIs('user.invoice.sales.return')) {
            $pageTitle = __('messages.sales') . ' ' . __('messages.return') . ' ' . __('messages.list');
        } else {
            $pageTitle = __('messages.add') . ' ' . __('messages.invoice');
        }
        return $dataTable->render('user.invoice.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->routeIs('user.invoice.create.draft')) {
            $pageTitle = __('messages.add') . ' ' . __('messages.draft');
        } elseif (request()->routeIs('user.invoice.create.return')) {
            $pageTitle = __('messages.add') . ' ' . __('messages.sales') . ' ' . __('messages.return');
        } else {
            $pageTitle = __('messages.add') . ' ' . __('messages.invoice');
        }
        return view('user.invoice.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        try {
            DB::beginTransaction();

            $totalQuantity = 0;
            foreach ($request->ordered_items as $value) {
                $totalQuantity += $value['return_quantity'];
            }

            $staff = $request->staff_id ? User::findOrFail($request->staff_id) : Auth::user();

            $invoice = new Invoice();
            $invoice->client_id = $request->client_id;
            $invoice->track_number = $request->track_number;
            $invoice->issued_date = bnToEnDate($request->issued_date) ?? now();
            $invoice->issued_time = $request->issued_time;
            $invoice->discount_type = $request->discount_type ?? 'flat';
            $invoice->discount = $request->discount ?? 0;
            $invoice->total_return = $totalQuantity ?? null;
            $invoice->transport_fare = $request->transport_fare ?? 0;
            $invoice->labour_cost = $request->labour_cost ?? 0;
            $invoice->account_id = $request->account_id;
            $invoice->bank_id = $request->bank_id ?? null;
            $invoice->cheque_number = $request->cheque_number ?? null;
            $invoice->cheque_issued_date = $request->cheque_issued_date == null ? null : bnToEnDate($request->cheque_issued_date);

            $invoice->category_id = $request->category_id;
            $invoice->receive_amount = $request->receive_amount ?? 0;
            $invoice->cash_receive = $request->cash_receive ?? 0;
            $invoice->change_amount = $request->change_amount ?? 0;
            $invoice->bill_amount = $request->bill_amount ?? 0;
            $invoice->due_amount = $request->due_amount ?? 0;
            $invoice->highest_due = $request->highest_due ?? 0;
            $invoice->vat_type = $request->vat_type ?? 'flat';
            $invoice->vat = $request->vat ?? 0;
            $invoice->description = $request->description;

            $invoice->total_discount = $request->total_discount;
            $invoice->invoice_bill = $request->invoice_bill;
            $invoice->previous_due = $request->previous_due;
            $invoice->due_before_return = $request->due_before_return; // for sales return
            $invoice->total_vat = $request->total_vat;
            $invoice->grand_total = $request->grand_total;
            $invoice->total_due = $request->total_due;
            $invoice->adjusting_amount = $request->adjusting_amount;
            $invoice->send_sms = $request->send_sms;
            $invoice->send_email = $request->send_email;
            $invoice->created_by = Auth::user()->username;
            $invoice->prepared_by = $staff->username ?? Auth::user()->username;
            if ($request->status == 'invoice-return') {
                $status = 4; // for sales return
            } elseif ($request->status == 'invoice-draft') {
                $status = 5; // for draft
            } else {
                $status = 0; // for invoice
            }
            $invoice->status = $status;
            $invoice->save();

            $invoice_items = $request->ordered_items;
            // add invoice product items to the invoice_items table
            foreach ($invoice_items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'issued_date' => $invoice->issued_date,
                    'purchased_id' => $item['purchased_id'],
                    'row_id' => $item['row_id'],
                    'product_id' => $item['product_id'],
                    'description' => $item['description'],
                    'stock' => $item['stock'],
                    'buying_price' => $item['buying_price'],
                    'selling_price' => $item['selling_price'],
                    'selling_type' => $item['selling_type'],
                    'wholesale_price' => $item['selling_type'] == 'wholesale' ? $item['selling_price'] : 0,
                    'quantity' => $item['quantity'],
                    'return_type' => $item['return_type'],
                    'unit_id' => $item['unit_id'],
                    'total' => $item['total'],
                    'status' => $status,
                    'created_by' => Auth::user()->username,
                    'prepared_by' => $staff->username ?? Auth::user()->username,
                ]);
            }
            $data = new Transaction();
            $account = Account::findOrFail($request->account_id);
            $currentDue = $request->grand_total - $request->receive_amount;
            if ($invoice->status == 4) { // for sales return
                $this->adjustBalance($account->id, 'cost', $request->receive_amount);
                $balance = $account->account_balance;
                $data->type = 'return';
                $data->transaction_type = 'money_return';
                // $data->type = 'cost';
                // $data->transaction_type = 'invoice-return';
                $data->current_due = $request->adjusting_amount;
            } else {
                $this->adjustBalance($account->id, 'deposit', $request->receive_amount);
                $balance = $account->account_balance;
                $data->type = 'deposit';
                $data->transaction_type = 'invoice';
                $data->current_due = $currentDue;
            }
            $data->client_id = $request->client_id;
            $data->invoice_id = $invoice->id;
            $data->date = bnToEnDate($request->issued_date) ?? now();
            $data->account_id = $request->account_id;
            $data->description = $request->description;
            $data->amount = $request->receive_amount;
            $data->current_balance = $balance;
            $data->category_id = $request->category_id;
            $data->send_sms = $request->send_sms;
            $data->send_email = $request->send_email;
            $data->created_by = Auth::user()->username;
            $data->prepared_by = $staff->username ?? Auth::user()->username;
            $data->save();

            updateClientBalances($request->client_id);
            DB::commit();

            foreach ($invoice_items as $item) {
                setProductStock($item['product_id']);
            }

            $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $request->client_id);
            $invoiceDue = $this->invoiceDue($invoice->id);
            if ($request->send_sms === "true") {
                if ($request->client_id) {
                    sendSms('client', $request->client_id, 'invoice', null, null, $request->description, $invoice->grand_total, $invoice->receive_amount, $invoiceDue, $clientDue);
                }
            }
            if ($request->send_email === "true") {
                $company_name = config('company.name');
                $company_mobile = config('company.phone');
                $client = Client::findOrFail($request->client_id);
                $recipient = $client->email;
                if ($recipient != null) {
                    $message = invoiceSmsTemplate($client->client_name, $invoice->grand_total, $invoice->receive_amount, $invoiceDue, $clientDue, $company_name, $company_mobile);
                    Mail::to($recipient)->send(new InvoiceMail($invoice, $message));
                }
            }

            return response()->json($invoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with('invoiceItems')->findOrFail($id);
        if ($invoice->status == 4) {
            $payment = $this->returnInvoicePayment($id);
            $invoiceDue = $this->returnInvoiceDue($id);
        } else {
            $payment = $this->invoicePayment($id);
            $invoiceDue = $this->invoiceDue($id);
        }
        $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $invoice->client_id) - $invoiceDue;
        $totalDue = $invoice->grand_total + $previousDue;
        $netDue = $invoiceDue + $previousDue;
        if ($invoice->status == 4) {
            $pageTitle = __('messages.sales') . ' ' . __('messages.return');
        } else if ($invoice->status == 4) {
            $pageTitle = __('messages.invoice') . ' ' . __('messages.draft');
        } else {
            $pageTitle = __('messages.invoice');
        }
        if ($invoice->status == 4) {
            return view('user.invoice.return-view', compact('invoice', 'pageTitle', 'payment', 'previousDue', 'totalDue', 'invoiceDue', 'netDue'));
        } else {
            return view('user.invoice.view', compact('invoice', 'pageTitle', 'payment', 'previousDue', 'totalDue', 'invoiceDue', 'netDue'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function challan(string $id)
    {
        $invoice = Invoice::with('invoiceItems')->findOrFail($id);
        $payment = $this->invoicePayment($id);
        $invoiceDue = $this->invoiceDue($id);
        $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $invoice->client_id) - $invoiceDue;
        $totalDue = $invoice->grand_total + $previousDue;
        $netDue = $invoiceDue + $previousDue;
        $pageTitle = __('messages.challan');
        return view('user.invoice.challan', compact('invoice', 'pageTitle', 'payment', 'previousDue', 'totalDue', 'invoiceDue', 'netDue'));
    }

    /**
     * Display the specified resource.
     */
    public function posShow(string $id)
    {
        $pageTitle = __('messages.pos_view');
        $invoice = Invoice::with('invoiceItems')->findOrFail($id);
        $payment = $this->invoicePayment($id);
        $due = $this->invoiceDue($id);
        $invoiceDue = $this->invoiceDue($id);
        $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $invoice->client_id) - $invoiceDue;
        $totalDue = ($invoice->grand_total + $previousDue) - $payment;
        $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $invoice->client_id);
        return view('user.invoice.pos', compact('invoice', 'pageTitle', 'payment', 'due', 'clientDue', 'totalDue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = __('messages.edit') . ' ' . __('messages.invoice');
        $data = Invoice::findOrFail($id);
        $data['issued_date'] = enToBnDate($data->issued_date);
        $data['staff_id'] = User::where('username', $data->created_by)->first()->id;
        $data['cheque_issued_date'] = enToBnDate($data->cheque_issued_date);
        $data['client_name'] = $data->client->client_name ?? '';
        $data['ordered_items'] = InvoiceItem::with(['unit', 'product' => function ($query) {
            $query->with(['prices' => function ($query) {
                $query->select('product_id', 'selling_price', 'purchase_id');
            }]);
        }])->where('invoice_id', $data->id)->get();

        if (request()->ajax()) {
            return response()->json($data);
        }
        return view('user.invoice.create', compact('data', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $totalQuantity = 0;
            foreach ($request->ordered_items as $value) {
                $totalQuantity += $value['return_quantity'];
            }

            $staff = $request->staff_id ? User::findOrFail($request->staff_id) : Auth::user();

            $invoice = Invoice::findOrFail($id);
            $invoice->client_id = $request->client_id;
            $invoice->track_number = $request->track_number;
            $invoice->issued_date = bnToEnDate($request->issued_date) ?? now();
            $invoice->issued_time = $request->issued_time;
            $invoice->discount_type = $request->discount_type ?? 'flat';
            $invoice->discount = $request->discount ?? 0;
            $invoice->total_return = $totalQuantity ?? $invoice->total_return;
            $invoice->transport_fare = $request->transport_fare ?? 0;
            $invoice->labour_cost = $request->labour_cost ?? 0;
            $invoice->account_id = $request->account_id;

            $invoice->bank_id = $request->bank_id;
            $invoice->cheque_number = $request->cheque_number;
            $invoice->cheque_issued_date = $request->cheque_issued_date == null ? null : bnToEnDate($request->cheque_issued_date);

            $invoice->category_id = $request->category_id;
            $invoice->receive_amount = $request->receive_amount ?? 0;
            $invoice->cash_receive = $request->cash_receive ?? 0;
            $invoice->change_amount = $request->change_amount ?? 0;
            $invoice->bill_amount = $request->bill_amount ?? 0;
            $invoice->due_amount = $request->due_amount ?? 0;
            $invoice->highest_due = $request->highest_due ?? 0;
            $invoice->vat_type = $request->vat_type ?? 'flat';
            $invoice->vat = $request->vat ?? 0;
            $invoice->description = $request->description;

            $invoice->total_discount = $request->total_discount;
            $invoice->invoice_bill = $request->invoice_bill;
            $invoice->previous_due = $request->previous_due;
            $invoice->due_before_return = $request->due_before_return; // for sales return
            $invoice->total_vat = $request->total_vat;
            $invoice->grand_total = $request->grand_total;
            $invoice->total_due = $request->total_due;
            $invoice->adjusting_amount = $request->adjusting_amount;
            $invoice->send_sms = $request->send_sms;
            $invoice->send_email = $request->send_email;
            $invoice->updated_by = $staff->username ?? Auth::user()->username;
            $invoice->save();

            // Update or create invoice items
            $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
            foreach ($invoiceItems as $item) {
                $invoiceItem = InvoiceItem::findOrFail($item->id);
                $invoiceItem->forceDelete();
            }

            $invoice_items = $request->ordered_items;
            foreach ($invoice_items as $item) {
                $invoiceItemData = [
                    'invoice_id' => $invoice->id,
                    'issued_date' => $invoice->issued_date,
                    'purchased_id' => $item['purchased_id'],
                    'row_id' => $item['row_id'],
                    'product_id' => $item['product_id'],
                    'description' => $item['description'],
                    'stock' => $item['stock'],
                    'buying_price' => $item['buying_price'],
                    'selling_price' => $item['selling_price'],
                    'selling_type' => $item['selling_type'],
                    'wholesale_price' => $item['selling_type'] == 'wholesale' ? $item['selling_price'] : 0,
                    'quantity' => $item['quantity'],
                    'return_type' => $item['return_type'],
                    'unit_id' => $item['unit_id'],
                    'total' => $item['total'],
                    'return_quantity' => $item['return_quantity'] ?? 0, // Add return_quantity field
                    'created_by' => Auth::user()->username,
                    'prepared_by' => $staff->username ?? Auth::user()->username,
                    'status' => $invoice->status, // 5 for draft and 4 for sales return
                ];

                InvoiceItem::create($invoiceItemData);
            }
            if ($invoice->status == 5) { // for draft
                $account = Account::findOrFail($request->account_id);
                $this->adjustBalance($account->id, 'deposit', $request->receive_amount);
                $balance = $account->account_balance;

                $data = new Transaction();
                $data->type = 'deposit';
                $data->transaction_type = 'invoice';
                $data->client_id = $request->client_id;
                $data->invoice_id = $invoice->id;
                $data->date = bnToEnDate($request->issued_date) ?? now();
                $data->account_id = $request->account_id;
                $data->description = $request->description;
                $data->amount = $request->receive_amount;
                $data->current_balance = $balance;
                $data->category_id = $request->category_id;
                $data->send_sms = $request->send_sms;
                $data->send_email = $request->send_email;
                $data->created_by = Auth::user()->username;
                $data->prepared_by = $staff->username ?? Auth::user()->username;
                $data->save();
            } else if ($invoice->status == 4) { // for sales return
                $transaction = Transaction::where('transaction_type', 'money_return')->where('invoice_id', $id)->first();

                $account = Account::findOrFail($request->account_id);
                $this->adjustBalance($account->id, 'cost', $request->receive_amount, $transaction->amount);
                $balance = $account->account_balance;

                $invoiceDue = $this->invoiceDue($id) + $transaction->amount;
                $currentDue = $request->amount - $invoiceDue;

                $data = Transaction::findOrFail($transaction->id);
                $data->client_id = $request->client_id;
                $data->amount = $request->receive_amount;
                $data->date = bnToEnDate($request->issued_date) ?? now();
                $data->current_due = $currentDue;
                $data->current_balance = $balance;
                $data->category_id = $request->category_id;
                $data->send_sms = $request->send_sms;
                $data->send_email = $request->send_email;
                $data->updated_by = Auth::user()->username;
                $data->save();
            } else {
                $transaction = Transaction::where('transaction_type', 'invoice')->where('invoice_id', $id)->first();

                $account = Account::findOrFail($request->account_id);
                $this->adjustBalance($account->id, 'deposit', $request->receive_amount, $transaction->amount);
                $balance = $account->account_balance;

                $invoiceDue = $this->invoiceDue($id) + $transaction->amount;
                $currentDue = $request->amount - $invoiceDue;

                $data = Transaction::findOrFail($transaction->id);
                $data->client_id = $request->client_id;
                $data->amount = $request->receive_amount;
                $data->date = bnToEnDate($request->issued_date) ?? now();
                $data->current_due = $currentDue;
                $data->current_balance = $balance;
                $data->category_id = $request->category_id;
                $data->send_sms = $request->send_sms;
                $data->send_email = $request->send_email;
                $data->updated_by = Auth::user()->username;
                $data->save();
            }
            if ($invoice->status == 4) {
                $invoice->status == 4;
            } else {
                $invoice->status = $request->status;
            }
            $invoice->save();
            DB::commit();

            foreach ($invoice_items as $item) {
                setProductStock($item['product_id']);
            }

            updateClientBalances($invoice->client_id);
            return response()->json($invoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $invoice = Invoice::findOrFail($id);
        $clientId = $invoice->client_id;
        // delete all invoice items
        $product_ids = [];
        foreach ($invoice->invoiceItems as $item) {
            $product_ids[] = $item->product_id;
            $this->deleteLog(InvoiceItem::class, $item->id);
        }
        // delete all the transaction under the invoice
        $transactions = Transaction::where('invoice_id', $id)->get();
        foreach ($transactions as $transaction) {
            $this->deleteLog(Transaction::class, $transaction->id);
        }
        // delete the invoice
        $this->deleteLog(Invoice::class, $id);

        foreach ($product_ids as $product_id) {
            setProductStock($product_id);
        }
        updateClientBalances($clientId);
        toast('Invoice Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }

    public function destroyItem(string $id)
    {
        // $data = InvoiceItem::findOrFail($id)->delete();
        // return response()->json($data);
    }

    public function shareInvoice($invoice_id)
    {
        $invoice = Invoice::with(['client', 'invoiceItems', 'invoiceItems.product', 'invoiceItems.unit', 'category', 'account'])->findOrFail($invoice_id);
        $invoiceUrl = route('invoice.view', ['id' => $invoice->id]);
        $title = "Invoice #{$invoice->id} - Client: {$invoice->client->name}, Amount: {$invoice->total_amount}";
        $shareComponent = ShareFacade::page($invoiceUrl)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

        $pageTitle = __('messages.share');
        return view('user.invoice.share', compact('pageTitle', 'shareComponent', 'invoice'));
    }
}
