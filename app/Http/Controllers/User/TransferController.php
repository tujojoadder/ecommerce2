<?php

namespace App\Http\Controllers\User;

use App\DataTables\TransferDataTable;
use App\Helpers\AccountBalanceHelper;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    use AccountBalanceTrait, DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(TransferDataTable $dataTable)
    {
        $pageTitle = __('messages.transfer') . ' ' . __('messages.list');
        if (request()->ajax()) {

            $balance = 0;
            $totalDebit = 0;
            $totalCredit = 0;
            $data = Transaction::where('transaction_type', 'transfer');
            if (request()->account_id) {
                $data->where('transaction_type', 'transfer')->where('account_id', request()->account_id);
            }
            if (request()->type) {
                $data->where('transaction_type', 'transfer')->where('type', request()->type);
            }
            if (request()->starting_date && request()->ending_date) {
                $data->where('transaction_type', 'transfer')->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
            }

            $data = $data->latest()->get();

            foreach ($data as $transaction) {
                if ($transaction->type == 'deposit') {
                    $balance += $transaction->amount;
                    $totalCredit += $transaction->amount;
                } elseif ($transaction->type == 'cost' || $transaction->type == 'return') {
                    $balance -= $transaction->amount;
                    $totalDebit += $transaction->amount;
                }

                $transaction->balance = $balance;
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($row) {
                    return bnDateFormat($row->date);
                })
                ->editColumn('sender_or_receiver', function ($row) {
                    if ($row->type == 'cost') {
                        return 'Sender';
                    } else {
                        return 'Receiver';
                    }
                })
                ->editColumn('source', function ($row) {
                    if ($row->client_id == !null) {
                        $clientName = $row->client->client_name ?? '';
                        return 'Client: ' . '<a href="' . route('user.client.view', $row->client_id) . '">' . $clientName ?? '' . '</a>';
                    } elseif ($row->supplier_id == !null) {
                        return 'Supplier: ' . $row->supplier->supplier_name ?? '--';
                    } else {
                        return 'Transfer';
                    }
                })
                ->addColumn('description', function ($row) {
                    if (strlen($row->description) > 30) {
                        $shortenedString = substr($row->description, 0, 30) . "...";
                    } else {
                        $shortenedString = $row->description;
                    }
                    return $shortenedString;
                })
                ->editColumn('account_id', function ($row) {
                    return Str::upper($row->account->title ?? 'N/A');
                })
                ->editColumn('type', function ($row) {
                    return Str::upper($row->type ?? 'N/A');
                })
                ->addColumn('credit', function ($row) {
                    if ($row->type == 'deposit') {
                        return $row->amount ?? '--';
                    } else {
                        return '--';
                    }
                })
                ->addColumn('debit', function ($row) {
                    if ($row->type == 'cost') {
                        return $row->amount ?? '--';
                    } elseif ($row->type == 'return') {
                        return $row->amount ?? '--';
                    } else {
                        return '--';
                    }
                })
                ->editColumn('balance', function ($row) {
                    return $row->balance;
                })
                ->addColumn('action', function ($row) {
                    if ($row->type == 'cost') {
                        // $editbtn = Gate::any(['access-all', 'transfer-edit']) ? '<a href="' . route('user.transfer.edit', $row->transfer_id) . '" id="incomeCategoryEditBtn" class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>' : '';
                        $deletebtn = Gate::any(['access-all', 'transfer-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->transfer_id . ')"><i class="fas fa-trash"></i></a>' : '';
                    } else {
                        $editbtn = '';
                        $deletebtn = '';
                    }
                    $dropdown = '
                        <div class="d-flex justify-content-between">
                        ' . $deletebtn . '
                        </div>
                    ';
                    return $dropdown;
                })
                ->rawColumns(['action', 'source', 'referrer', 'description', 'sender_or_receiver'])
                ->make(true);
        }
        return view('user.accounts.transfer.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.new') . ' ' . __('messages.transfer');
        return view('user.accounts.transfer.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferRequest $request)
    {
        try {
            DB::beginTransaction();
            $fromAccount = Account::findOrFail($request->from_account_id);
            $fromAccountBalance = $fromAccount->balance($request->from_account_id);
            if (config('transfers_with_insufficient_balance') == 0) {
                if ($fromAccountBalance <= $request->amount) {
                    toastr()->error('This account does not have enough balance to send!', 'Insufficient Balance!');
                    return redirect()->back()->with(['error' => 'This (' . $fromAccount->title . ') account does not have enough balance to send!']);
                }
            }
            $this->adjustBalance($fromAccount->id, 'cost', $request->amount);
            $decreasedBalance = $fromAccount->account_balance;

            $toAccount = Account::findOrFail($request->to_account_id);
            $this->adjustBalance($toAccount->id, 'deposit', $request->amount);
            $increaseBalance = $toAccount->account_balance;


            $decrease = new Transaction();
            $decrease->type = 'cost';
            $decrease->transaction_type = 'transfer';
            $decrease->date = bnToEnDate($request->date);
            $decrease->account_id = $request->from_account_id;
            $decrease->amount = $request->amount;
            $decrease->transfer_id = time();
            $decrease->current_balance = $decreasedBalance;
            $decrease->payment_id = $request->payment_id;
            $decrease->description = $request->description;
            $decrease->reference = $request->reference;
            $decrease->tags = $request->tags;
            $decrease->created_by = Auth::user()->username;
            $decrease->save();

            // increase from receiver account

            $increase = new Transaction();
            $increase->type = 'deposit';
            $increase->transaction_type = 'transfer';
            $increase->date = bnToEnDate($request->date);
            $increase->account_id = $request->to_account_id;
            $increase->amount = $request->amount;
            $increase->transfer_id = time();
            $increase->current_balance = $increaseBalance;
            $increase->payment_id = $request->payment_id;
            $increase->description = $request->description;
            $increase->reference = $request->reference;
            $increase->tags = $request->tags;
            $increase->created_by = Auth::user()->username;
            $increase->save();

            DB::commit();

            toast('Balance Transfered Successfully!', 'success');
            return redirect()->route('user.transfer.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = __('messages.edit') . ' ' . __('messages.transfer');
        $sender = Transaction::where('transfer_id', $id)->where('type', 'cost')->first();
        $receiver = Transaction::where('transfer_id', $id)->where('type', 'deposit')->first();
        return view('user.accounts.transfer.create', compact('pageTitle', 'sender', 'receiver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransferRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $fromAccount = Account::findOrFail($request->from_account_id);
            if (config('transfers_with_insufficient_balance') == 0) {
                if ($fromAccount->account_balance <= $request->amount) {
                    toastr()->error('This account does not have enough balance to send!', 'Insufficient Balance!');
                    return redirect()->back()->with(['error' => 'This (' . $fromAccount->title . ') account does not have enough balance to send!']);
                }
            }
            $sender = Transaction::where('transfer_id', $id)->where('type', 'cost')->first();
            if ($request->amount == $sender->amount) {
                $decreasedBalance = $sender->amount;
            } else {
                $this->adjustBalance($fromAccount->id, 'cost', $request->amount, $sender->amount);
                $decreasedBalance = $fromAccount->account_balance;
            }

            $receiver = Transaction::where('transfer_id', $id)->where('type', 'deposit')->first();
            if ($request->amount == $receiver->amount) {
                $increaseBalance = $receiver->amount;
            } else {
                $toAccount = Account::findOrFail($request->to_account_id);
                $this->adjustBalance($toAccount->id, 'deposit', $request->amount, $receiver->amount);
                $increaseBalance = $toAccount->account_balance;
            }

            $decrease = Transaction::findOrFail($sender->id);
            $decrease->type = 'cost';
            $decrease->transaction_type = 'transfer';
            $decrease->date = bnToEnDate($request->date);
            $decrease->account_id = $request->from_account_id;
            $decrease->amount = $request->amount;
            $decrease->transfer_id = time();
            $decrease->current_balance = $decreasedBalance;
            $decrease->payment_id = $request->payment_id;
            $decrease->description = $request->description;
            $decrease->reference = $request->reference;
            $decrease->tags = $request->tags;
            $decrease->created_by = Auth::user()->username;
            $decrease->save();

            // increase from receiver account
            $increase = Transaction::findOrFail($receiver->id);
            $increase->type = 'deposit';
            $increase->transaction_type = 'transfer';
            $increase->date = bnToEnDate($request->date);
            $increase->account_id = $request->to_account_id;
            $increase->amount = $request->amount;
            $increase->transfer_id = time();
            $increase->current_balance = $increaseBalance;
            $increase->payment_id = $request->payment_id;
            $increase->description = $request->description;
            $increase->reference = $request->reference;
            $increase->tags = $request->tags;
            $increase->created_by = Auth::user()->username;
            $increase->save();

            DB::commit();

            toast('Balance Transfer updated Successfully!', 'success');
            return redirect()->route('user.transfer.index');
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
        try {
            DB::beginTransaction();
            $sender = Transaction::where('transfer_id', $id)->where('type', 'cost')->first();
            $fromAccount = Account::withTrashed()->findOrFail($sender->account_id);
            $fromAccount->account_credit = $fromAccount->account_credit + $sender->amount;
            $fromAccount->account_debit = $fromAccount->account_debit - $sender->amount;
            $fromAccount->account_balance = $fromAccount->account_balance + $sender->amount;
            $fromAccount->save();

            $receiver = Transaction::where('transfer_id', $id)->where('type', 'deposit')->first();
            $toAccount = Account::withTrashed()->findOrFail($receiver->account_id);
            $toAccount->account_credit = $toAccount->account_credit - $sender->amount;
            $toAccount->account_debit = $toAccount->account_debit + $sender->amount;
            $toAccount->account_balance = $toAccount->account_balance - $sender->amount;
            $toAccount->save();

            DB::commit();

            /**
             * For the delete log
             * 1. Model Name
             * 2. Row ID
             */
            $this->deleteLog(Transaction::class, $sender->id);
            $this->deleteLog(Transaction::class, $receiver->id);

            toast('Transfer Deleted Successfully!', 'error', 'top-right');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
