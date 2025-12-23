<?php

namespace App\Http\Controllers\User\Accounts;

use App\DataTables\AccountBalanceDataTable;
use App\DataTables\AccountDataTable;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    use DeleteLogTrait, AccountBalanceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(AccountDataTable $dataTable)
    {
        $pageTitle = __('messages.account') . ' ' . __('messages.list');
        return $dataTable->render('user.accounts.account.index', compact('pageTitle'));
    }

    public function total()
    {
        $pageTitle = __('messages.total');
        return view('user.accounts.account.total', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.add_new_account');
        return view('user.accounts.account.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        try {
            $account = new Account($request->all());
            $account->created_by = Auth::user()->username;
            $account->account_debit = 0;
            $account->account_credit = $request->initial_balance ?? 0;
            $account->account_balance = $request->initial_balance ?? 0;
            $account->save();

            $transaction = new Transaction();
            $transaction->type = 'deposit';
            $transaction->transaction_type = 'account';
            $transaction->date = date('Y-m-d');
            $transaction->account_id = $account->id;
            $transaction->description = $request->description;
            $transaction->amount = $request->initial_balance ?? 0;
            $transaction->current_balance = $request->initial_balance ?? 0;
            $transaction->current_due = 0;
            $transaction->created_by = Auth::user()->created_by;
            $transaction->save();

            toast('Account Created Successfully!', 'success');
            if (request()->ajax()) {
                return response()->json($account);
            }
            return redirect()->route('user.account.index');
        } catch (\Throwable $th) {
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
        try {
            $pageTitle = __('messages.edit') . ' ' . __('messages.account');
            $account = Account::findOrFail($id);
            return view('user.accounts.account.create', compact('pageTitle', 'account'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $account = Account::findOrFail($id);
            $account->update($request->except('_token', '_method'));
            $account->created_by = Auth::user()->username;

            $this->adjustBalance($account->id, 'update-account', $request->initial_balance, $account->initial_balance);

            $account->save();

            $transaction = Transaction::where('account_id', $account->id)->first(); // finding account initial transaction
            $transaction->type = 'deposit';
            $transaction->transaction_type = 'account';
            $transaction->date = date('Y-m-d');
            $transaction->account_id = $account->id;
            $transaction->description = $request->description;
            $transaction->amount = $request->initial_balance;
            $transaction->current_due = 0;
            $transaction->current_balance = $request->initial_balance;
            $transaction->created_by = Auth::user()->created_by;
            $transaction->save();

            toast('Account Updated Successfully!', 'success');
            return redirect()->route('user.account.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $transactions = Transaction::where('account_id', $id)->count();
        if ($transactions > 0) {
            toast('Account has transactions. Please delete the transactions first!', 'error', 'top-right');
            return response()->json(['error' => 'Account has transactions. Please delete the transactions first!']);
        }
        foreach ($transactions as $key => $item) {
            $this->deleteLog(Transaction::class, $item->id);
        }
        $this->deleteLog(Account::class, $id);
        toast('Account Deleted Successfully!', 'error', 'top-right');
        return response()->json(['success' => 'Account Deleted Successfully!']);
    }

    public function balance(AccountBalanceDataTable $dataTable)
    {
        try {
            $pageTitle = __('messages.account') . ' ' . __('messages.balance') . ' ' . __('messages.list');
            return $dataTable->render('user.accounts.account.balance', compact('pageTitle'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function viewStatement()
    {
        try {
            $pageTitle = __('messages.account') . ' ' . __('messages.statement');
            if (request()->ajax()) {

                $balance = 0;
                $totalDebit = 0;
                $totalCredit = 0;

                $data = Transaction::where('type', '!=', 'previous_due')->where(function ($query) {
                    $query->where('type', '!=', 'deposit')
                        ->orWhere('transaction_type', '!=', 'transfer');
                })->where('deleted_at', null)->orderBy('date', 'asc')->newQuery();
                if (request()->client_id) {
                    $data->where('client_id', request()->client_id);
                }
                if (request()->account_id) {
                    $data->where('account_id', request()->account_id);
                }
                if (request()->type) {
                    $data->where('type', request()->type);
                }
                if (request()->starting_date && request()->ending_date) {
                    $data->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
                }

                $data = $data->get();
                $dataCollection = $data;
                if (request()->starting_date && request()->ending_date) {
                    $openingBalance = 0;
                    $openingCredit = 0;
                    $openingDebit = 0;
                    $startDate = bnToEnDate(request()->starting_date, null, 1);

                    // Fetch the openingData
                    $openingData = Transaction::where('type', '!=', 'previous_due')->where(function ($query) {
                        $query->where('type', '!=', 'deposit')
                            ->orWhere('transaction_type', '!=', 'transfer');
                    })->where('deleted_at', null)
                        ->when(request()->account_id, function ($query) {
                            return $query->where('account_id', request()->account_id);
                        })->when(request()->client_id, function ($query) {
                            return $query->where('client_id', request()->client_id);
                        })->when(request()->type, function ($query) {
                            return $query->where('type', request()->type);
                        })->whereDate('date', '<=', $startDate)->orderBy('date', 'desc')->get();

                    foreach ($openingData as $transaction) {
                        if ($transaction->type == 'deposit') {
                            $openingBalance += $transaction->amount;
                            $openingCredit += $transaction->amount;
                        } elseif ($transaction->type == 'cost' || $transaction->type == 'return') {
                            $openingBalance -= $transaction->amount;
                            $openingDebit += $transaction->amount;
                        }
                    }

                    if ($openingData->count() > 0) {
                        $firstOpeningData = $openingData->first();
                        if ($firstOpeningData->type == 'deposit') {
                            $openingBalance -= $firstOpeningData->amount;
                        } else {
                            $openingBalance += $firstOpeningData->amount;
                        }
                        $firstOpeningData->balance += $openingBalance;
                        $dataCollection->prepend($firstOpeningData);
                    } else {
                        $firstOpeningData = null;
                    }
                } else {
                    $firstOpeningData = null;
                    $openingBalance = 0;
                }

                foreach ($data as $transaction) {
                    if ($transaction->type == 'deposit') {
                        $balance += $transaction->amount;
                        $totalCredit += $transaction->amount;
                    } elseif ($transaction->type == 'cost' || $transaction->type == 'return') {
                        $balance -= $transaction->amount;
                        $totalDebit += $transaction->amount;
                    }

                    $transaction->balance = $balance + $openingBalance;
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('date', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                            return bnDateFormat($firstOpeningData->date);
                        } else {
                            return bnDateFormat($row->date);
                        }
                    })
                    ->editColumn('source', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                            return __('messages.opening_balance');
                        } else {
                            if ($row->client_id == !null) {
                                $client =  $row->client->client_name ?? '____';
                                return 'Client: ' . $client;
                            } elseif ($row->supplier_id == !null) {
                                return 'Supplier: ' . $row->supplier->supplier_name ?? '--';
                            } else {
                                return 'Account';
                            }
                        }
                    })
                    ->addColumn('description', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        } else {
                            if (strlen($row->description) > 30) {
                                $shortenedString = mb_substr($row->description, 0, 30, 'UTF-8') . "...";
                            } else {
                                $shortenedString = $row->description;
                            }
                            if ($row->transaction_type == 'account') {
                                return __('messages.initial');
                            }
                            if ($row->type == 'deposit') {
                                return __('messages.collection');
                            }
                            if ($row->transaction_type == 'purchase') {
                                return __('messages.purchase');
                            }
                            if ($row->transaction_type == 'supplier_payment') {
                                return __('messages.payment');
                            }
                            return $shortenedString;
                        }
                    })
                    ->editColumn('account_id', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        } else {
                            return Str::upper($row->account->title ?? 'N/A');
                        }
                    })
                    ->editColumn('bank_id', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        } else {
                            return $row->bank->name ?? '';
                        }
                    })
                    ->editColumn('type', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        } else {
                            if ($row->transaction_type == 'transfer') {
                                return Str::upper($row->type ?? 'N/A') . ' (Transfer)';
                            } else {
                                return Str::upper($row->type ?? 'N/A');
                            }
                        }
                    })
                    ->addColumn('credit', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                            return number_format(0, 2);
                        } else {
                            if ($row->type == 'deposit') {
                                return $row->amount ?? 0;
                            } elseif ($row->type == 'previous_due' && $row->client_id == !null) {
                                return $row->amount ?? 0;
                            } else {
                                return number_format(0, 2);
                            }
                        }
                    })
                    ->addColumn('debit', function ($row) use ($firstOpeningData) {
                        $checkIf = $firstOpeningData->date ?? null;
                        if ($checkIf != null && $firstOpeningData->date == $row->date) {
                            return number_format(0, 2);
                        } else {
                            if ($row->type == 'cost') {
                                return $row->amount ?? 0;
                            } elseif ($row->type == 'return') {
                                return $row->amount ?? 0;
                            } elseif ($row->type == 'previous_due' && $row->supplier_id == !null) {
                                return $row->amount ?? 0;
                            } else {
                                return number_format(0, 2);
                            }
                        }
                    })
                    ->editColumn('balance', function ($row) use ($firstOpeningData) {
                        return str_replace(',', '', number_format($row->balance, 2));
                    })
                    ->rawColumns(['source', 'referrer', 'description'])
                    ->make(true);
            }
            return view('user.accounts.account.view-statements', compact('pageTitle'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
