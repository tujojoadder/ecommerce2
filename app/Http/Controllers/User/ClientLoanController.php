<?php

namespace App\Http\Controllers\User;

use App\DataTables\LoanDataTable;
use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Http\Controllers\Controller;
use App\Mail\ReceiveMail;
use App\Models\Account;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientLoanController extends Controller
{
    use AccountBalanceTrait;
    public function index(LoanDataTable $dataTable)
    {
        if (request()->has('create-receive')) {
            $pageTitle = __('messages.create_loan_receive');
        } else if (request()->has('create-payment')) {
            $pageTitle = __('messages.create_loan_payment');
        } else {
            $pageTitle = __('messages.loan_list');
        }
        return $dataTable->render('user.accounts.loan.index', compact('pageTitle'));
    }
    public function loanReceiveOrPayment(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->amount <= 0) {
                toast('Please amount can not be zero(0)');
                return redirect()->back();
            }
            $account = Account::findOrFail($request->account_id);
            if ($request->type == 'receive') {
                $this->adjustBalance($account->id, 'deposit', $request->amount);
            } else {
                $this->adjustBalance($account->id, 'cost', $request->amount);
            }
            $balance = $account->account_balance;

            $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $request->client_id);
            $currentDue = $clientDue - $request->amount;

            $data = new Transaction();
            if ($request->type == 'receive') {
                $currentDue = $clientDue - $request->amount;
                $data->type = 'deposit';
                $data->transaction_type = 'loan_receive';
            } else {
                $currentDue = $clientDue + $request->amount;
                $data->type = 'cost';
                $data->transaction_type = 'loan_payment';
            }
            $data->client_id = $request->client_id;
            $data->date = bnToEnDate($request->date);
            $data->account_id = $request->account_id;
            $data->description = $request->description;
            $data->amount = $request->amount;
            $data->current_due = $currentDue;
            $data->current_balance = $balance;
            $data->category_id = $request->category_id;
            $data->send_sms = $request->send_sms;
            $data->send_email = $request->send_email;
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();
            $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $request->client_id);

            if ($request->send_sms === "true") {
                if ($request->client_id) {
                    $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $request->client_id);
                    $apiResponse = sendSms('client', $request->client_id, 'receive', $request->amount, $clientDue, $request->description);
                    $data->balance_status = getSmsStatus($apiResponse);
                    // return response()->json($data);
                }
            }
            if ($request->send_email === "true") {
                $company_name = config('company.name');
                $company_mobile = config('company.phone');
                $client = Client::findOrFail($request->client_id);
                $recipient = $client->email;
                $message = receiveSmsTemplate($client->client_name, $request->amount, $clientDue, $request->description, $company_name, $company_mobile);

                Mail::to($recipient)->send(new ReceiveMail($data, $message));
            }

            toast('Loan Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
