<?php

namespace App\Http\Controllers\User\Accounts;

use App\DataTables\ReceiveDataTable;
use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\Traits\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReceiveRequest;
use App\Mail\ReceiveMail;
use App\Models\Account;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReceiveController extends Controller
{
    use DeleteLogTrait, AccountBalanceTrait, InvoiceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ReceiveDataTable $dataTable)
    {
        $pageTitle = __('messages.receive') . ' ' . __('messages.list');
        return $dataTable->render('user.accounts.receive.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('user.accounts.receive.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceiveRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->amount <= 0) {
                toast('Please amount can not be zero(0)');
                return redirect()->back();
            }
            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'deposit', $request->amount);
            $balance = $account->account_balance;

            if ($request->client_id) {
                $client = Client::findOrFail($request->client_id);
                $clientDue = ($client->due ?? ClientBalanceHelper::getClientTotalDue(Transaction::class, $client->id));
                $currentDue = $clientDue - $request->amount;
            }

            $data = new Transaction();
            $data->type = 'deposit';
            if ($request->supplier_id != null) {
                $data->transaction_type = 'supplier_receive';
            } else {
                $data->transaction_type = 'deposit';
            }
            $data->client_id = $request->client_id ? $client->id : null;
            $data->supplier_id = $request->supplier_id;
            $data->invoice_id = $request->invoice_id;
            $data->date = bnToEnDate($request->date);
            $data->account_id = $request->account_id;
            $data->description = $request->description;
            $data->amount = $request->amount;
            $data->current_due = $currentDue ?? 0;
            $data->current_balance = $balance;
            $data->project_id = $request->project_id;
            $data->chart_account_id = $request->chart_account_id;
            $data->chart_group_id = $request->chart_group_id;
            $data->category_id = $request->category_id;
            $data->payment_id = $request->payment_id;
            $data->bank_id = $request->bank_id;
            $data->cheque_no = $request->cheque_no;
            $data->send_sms = $request->send_sms;
            $data->send_email = $request->send_email;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();
            if ($request->client_id) {
                updateClientBalances($client->id);

                $clientDue = ($client->due ?? ClientBalanceHelper::getClientTotalDue(Transaction::class, $client->id));

                if ($request->send_sms === "true") {
                    if ($client->id) {
                        $apiResponse = sendSms('client', $client->id, 'receive', $request->amount, $clientDue, $request->description);
                        $data->balance_status = getSmsStatus($apiResponse);
                        // return response()->json($data);
                    }
                }

                if ($request->send_email === "true") {
                    $company_name = config('company.name');
                    $company_mobile = config('company.phone');
                    $client = Client::findOrFail($client->id);
                    $recipient = $client->email;
                    $message = receiveSmsTemplate($client->client_name, $request->amount, $clientDue, $request->description, $company_name, $company_mobile);

                    Mail::to($recipient)->send(new ReceiveMail($data, $message));
                }
            }

            toast('Received Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $receiver_name = 'NULL';
        $receiver_phone = 'NULL';
        $receiver_bank = $transaction->bank->name ?? 'NULL';

        if ($transaction->client_id != NULL) {
            $client = Client::where('id', $transaction->client_id)->first();
            $receiver_name = $client->client_name;
            $receiver_phone = $client->phone;
        }
        if ($transaction->supplier_id != NULL) {
            $supplier = Supplier::findOrFail($transaction->supplier_id)->first();
            $receiver_name = $supplier->supplier_name;
            $receiver_phone = $supplier->phone;
        }

        return view('user.receipt.receive-voucher', compact('transaction', 'receiver_name', 'receiver_phone', 'receiver_bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Transaction::findOrFail($id);
        $data['date'] = enToBnDate($data->date);
        $data['client_id'] = $data->client_id;
        $data['client_name'] = $data->client->client_name ?? '';
        $data['supplier_name'] = $data->supplier->supplier_name ?? '';
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceiveRequest $request, string $id)
    {
        // $account = Account::findOrFail($request->account_id);
        // $total = $account->balance($request->account_id);
        // $balance = $total + $request->amount;
        try {
            DB::beginTransaction();

            $data = Transaction::findOrFail($id);

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'deposit', $request->amount, $data->amount);
            $balance = $account->account_balance;

            $client = Client::findOrFail($request->client_id);

            $clientDue = ($client->due ?? ClientBalanceHelper::getClientTotalDue(Transaction::class, $client->id)) + $data->amount;
            $currentDue = $clientDue - $request->amount;

            $data->type = 'deposit';
            $data->client_id = $client->id;
            $data->invoice_id = $request->invoice_id;
            $data->date = bnToEnDate($request->date);
            $data->account_id = $request->account_id;
            $data->description = $request->description;
            $data->amount = $request->amount;
            $data->current_due = $currentDue;
            $data->current_balance = $balance;
            $data->project_id = $request->project_id;
            $data->chart_account_id = $request->chart_account_id;
            $data->chart_group_id = $request->chart_group_id;
            $data->category_id = $request->category_id;
            $data->payment_id = $request->payment_id;
            $data->bank_id = $request->bank_id;
            $data->cheque_no = $request->cheque_no;
            $data->send_sms = $request->send_sms;
            $data->send_email = $request->send_email;
            $data->created_by = Auth::user()->created_by;
            $data->save();
            updateClientBalances($client->id);
            DB::commit();

            toast('Received Updated Successfully!', 'info');
            return response()->json($data);
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
        $data = Transaction::findOrFail($id);
        $clientId = $data->client_id;
        $this->deleteLog(Transaction::class, $id);
        updateClientBalances($clientId);
        toast('Receive Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
