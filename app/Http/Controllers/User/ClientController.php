<?php

namespace App\Http\Controllers\User;

use App\DataTables\ClientDataTable;
use App\DataTables\LoanClientDataTable;
use App\Helpers\ClientBalanceHelper;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ClientDataTable $dataTable)
    {
        $pageTitle = __('messages.customer') . ' ' . __('messages.list');
        return $dataTable->render('user.client.index', compact('pageTitle'));
    }

    public function remainingDueList(ClientDataTable $dataTable)
    {
        $pageTitle = __('messages.client_remaining_due_date');
        return $dataTable->render('user.client.due-list', compact('pageTitle'));
    }

    public function loanClient(LoanClientDataTable $dataTable)
    {
        $pageTitle = __('messages.customer') . ' ' . __('messages.list');
        return $dataTable->render('user.client.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.client') . ' ' . __('messages.create');
        return view('user.client.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        try {
            DB::beginTransaction();

            $account = Account::where('deleted_at', null)->first();
            if ($account == null) {
                alert('No account found!', 'Please create an account first it\'s related to the customer!', 'warning');
                return redirect()->route('user.account.create');
            }
            // Upload client image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('client-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload client image

            $client = new Client($request->all());
            $client->image = $image; // set image name into staff image field
            if ($request->client_type == 1) {
                $client->type = 1;
            } else {
                $client->type = 0;
            }
            $client->created_by = Auth::user()->username;
            $client->save();

            $account = Account::first();
            $accountId = $account->id;
            $this->adjustBalance($accountId, 'cost', $request->previous_due);
            $balance = $account->account_balance;

            Transaction::create([
                'description' => "Previous due",
                'date' => date('Y-m-d', strtotime($client->created_at)),
                'type' => 'previous_due',
                'transaction_type' => 'previous_due',
                'amount' => $client->previous_due ?? 0,
                'current_balance' => $balance, // Initialize balance with previous due amount
                'current_due' => $client->previous_due ?? 0, // Initialize balance with previous due amount
                'client_id' => $client->id,
                'account_id' => $accountId,
                'created_by' => Auth::user()->username,
            ]);

            updateClientBalances($client->id);
            DB::commit();

            if ($request->type == 'modal') {
                return response()->json($client);
            } else {
                toast('Client Added Successfully!', 'success');
                if ($request->client_type == 0) {
                    return redirect()->route('user.client.index');
                } else {
                    return redirect()->route('user.client.loan.client');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with('group')->findOrFail($id);
        $client['group_name'] = $client->group->name ?? '--';
        return response()->json($client);
    }

    /**
     * Display the client statements.
     */
    public function statements()
    {
        $pageTitle = __('messages.client') . ' ' . __('messages.statement');
        if (request()->ajax()) {
            $balance = 0;
            $totalDebit = 0;
            $totalCredit = 0;
            $data = Transaction::whereNotNull('client_id')->where('deleted_at', null)->orderBy('date', 'asc')->newQuery();

            if (request()->client_id) {
                $client = Client::findOrFail(request()->client_id);
                $data->where('client_id', $client->id);
            }

            if (request()->starting_date && request()->ending_date) {
                $startDate = bnToEnDate(request()->starting_date)->startOfDay();
                $endDate = bnToEnDate(request()->ending_date)->endOfDay();
                $data->whereBetween('date', [$startDate, $endDate]);
            }

            $dataCollection = $data->get();
            if (request()->starting_date && request()->ending_date) {
                $openingBalance = 0;
                $startDate = bnToEnDate(request()->starting_date, null, 1);

                // Fetch the openingData
                $openingData = Transaction::whereNotNull('client_id')
                    ->when(request()->client_id, function ($query) {
                        $query->where('client_id', request()->client_id);
                    })->whereDate('date', '<=', $startDate)->orderBy('date', 'desc')->get();

                foreach ($openingData as $row) {
                    $purchaseBill = 0;
                    $receiveOrCredit = 0;
                    $returnAmount = 0;
                    $moneyReturn = 0;

                    if ($row->type == 'previous_due') {
                        $purchaseBill = $row->amount;
                    } elseif ($row->transaction_type == 'money_return') {
                        $returnAmount = $row->invoice->grand_total ?? 0;
                    } elseif ($row->type == 'return') {
                        $moneyReturn = $row->amount ?? 0;
                    } elseif ($row->transaction_type == 'invoice') {
                        $purchaseBill = $row->invoice->grand_total ?? 0;
                    } elseif ($row->transaction_type == 'deposit' && $row->type == "deposit") {
                        $receiveOrCredit = $row->amount ?? 0;
                    } elseif ($row->type == 'cost') {
                        $purchaseBill = $row->amount ?? 0;
                    }

                    $receiveOrCredit = ($row->type == 'previous_due' || $row->type == 'return') ? 0 : $row->amount ?? 0;

                    if ($row->type == 'money_return') {
                        $thisBalance = ($purchaseBill - $returnAmount) - ($receiveOrCredit - $moneyReturn);
                    } elseif ($row->type == 'invoice') {
                        $thisBalance = $purchaseBill - $receiveOrCredit;
                    } elseif ($row->type == 'deposit') {
                        $thisBalance = ($purchaseBill - $moneyReturn) - $receiveOrCredit;
                    } elseif ($row->transaction_type == 'invoice' && $row->type == 'deposit') {
                        $thisBalance = ($purchaseBill - $moneyReturn) - $receiveOrCredit;
                    } else {
                        $thisBalance = ($purchaseBill - $returnAmount) + $moneyReturn;
                    }

                    $openingBalance += $thisBalance;
                }

                if ($openingData->count() > 0) {
                    $firstOpeningData = $openingData->first();
                    $firstOpeningData->fill([
                        'unit_id' => 'return',
                    ]);
                    $dataCollection->prepend($firstOpeningData);
                } else {
                    $firstOpeningData = null;
                }
            } else {
                $firstOpeningData = null;
                $openingBalance = 0;
            }

            return DataTables::of($dataCollection)
                ->addIndexColumn()
                ->editColumn('date', function ($row) use ($firstOpeningData) {
                    return bnDateFormat($row->date);
                })
                ->addColumn('product', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        return 'Opening Balance';
                    } else {
                        if ($row->transaction_type == 'invoice') {
                            $productNames = [];
                            foreach ($row->invoice->invoiceItems ?? [] as $item) {
                                $productNames[] = $item->product->name ?? 'N/A';
                            }
                            return implode('<br><hr class="m-0 bg-danger"> ', $productNames);
                        }
                        if ($row->transaction_type == 'previous_due') {
                            return __('messages.previous_due');
                        }
                    }
                    if ($row->transaction_type == 'deposit') {
                        return __('messages.collection');
                    }
                    if ($row->transaction_type == 'money_return') {
                        $adjustingAmount = $row->invoice->adjusting_amount ?? 0;
                        if ($adjustingAmount == 0) {
                            return __('messages.invoice') . ' ' . __('messages.return');
                        } else {
                            return __('messages.invoice') . ' ' . __('messages.return') . ' | ' . __('messages.adjusted') . ': ' . $adjustingAmount;
                        }
                    }
                    if ($row->transaction_type == 'money_return') {
                        return __('messages.money') . ' ' . __('messages.return');
                    }
                })
                ->addColumn('unit_id', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        if ($firstOpeningData->transaction_type == 'invoice' || $firstOpeningData->transaction_type == 'money_return') {
                            $unitIds = [];
                            foreach ($firstOpeningData->invoice->invoiceItems ?? [] as $item) {
                                $unitIds[] = $item->unit->name ?? 'N/A';
                            }
                            return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                        }
                    } else {
                        if ($row->transaction_type == 'invoice' || $row->transaction_type == 'money_return') {
                            $unitIds = [];
                            foreach ($row->invoice->invoiceItems ?? [] as $item) {
                                $unitIds[] = $item->unit->name ?? 'N/A';
                            }
                            return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                        }
                    }
                })
                ->addColumn('quantity', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        if ($firstOpeningData->transaction_type == 'invoice' || $firstOpeningData->transaction_type == 'money_return') {
                            $unitIds = [];
                            foreach ($firstOpeningData->invoice->invoiceItems ?? [] as $item) {
                                $unitIds[] = $item->quantity ?? '0';
                            }

                            return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                        }
                    } else {
                        if ($row->transaction_type == 'invoice' || $row->transaction_type == 'money_return') {
                            $unitIds = [];
                            foreach ($row->invoice->invoiceItems ?? [] as $item) {
                                $unitIds[] = $item->quantity ?? '0';
                            }

                            return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                        }
                    }
                })
                ->addColumn('price', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        if ($firstOpeningData->transaction_type == 'invoice' || $firstOpeningData->transaction_type == 'money_return') {
                            $price = [];
                            foreach ($firstOpeningData->invoice->invoiceItems ?? [] as $item) {
                                $price[] = $item->selling_price ?? '0';
                            }
                            return implode('<br><hr class="m-0 bg-danger"> ', $price);
                        }
                    } else {
                        if ($row->transaction_type == 'invoice' || $row->transaction_type == 'money_return') {
                            $price = [];
                            foreach ($row->invoice->invoiceItems ?? [] as $item) {
                                $price[] = $item->selling_price ?? '0';
                            }
                            return implode('<br><hr class="m-0 bg-danger"> ', $price);
                        }
                    }
                })
                ->addColumn('return', function ($row)  use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        if ($firstOpeningData->type == 'cost' && $firstOpeningData->transaction_type == 'money_return') {
                            $amount = $firstOpeningData->invoice->grand_total ?? 0;
                        } else if ($firstOpeningData->type == 'return') {
                            $amount = 0;
                        }
                        return round($amount ?? 0);
                    } else {
                        if ($row->type == 'return' && $row->transaction_type == 'money_return') {
                            $amount = $row->invoice->grand_total ?? 0;
                        } else if ($row->type == 'return') {
                            $amount = 0;
                        }
                        return round($amount ?? 0);
                    }
                })
                ->addColumn('purchase_bill', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        if ($firstOpeningData->type == 'previous_due') {
                            $amount = $firstOpeningData->amount ?? 0;
                        } else if ($firstOpeningData->transaction_type == 'money_return') {
                            $amount = 0;
                        } else if ($firstOpeningData->transaction_type == 'invoice') {
                            $amount = $firstOpeningData->invoice->grand_total ?? 0;
                        } else if ($firstOpeningData->type == 'cost') {
                            $amount = $firstOpeningData->amount ?? 0;
                        } else {
                            $amount = 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    } else {
                        if ($row->type == 'previous_due') {
                            $amount = $row->amount ?? 0;
                        } else if ($row->transaction_type == 'money_return') {
                            $amount = 0;
                        } else if ($row->transaction_type == 'invoice') {
                            $amount = $row->invoice->grand_total ?? 0;
                        } else if ($row->type == 'cost') {
                            $amount = $row->amount ?? 0;
                        } else {
                            $amount = 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    }
                })

                ->addColumn('receive_or_credit', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        if ($firstOpeningData->type == 'previous_due') {
                            $amount = 0;
                        } else if ($firstOpeningData->type == 'return') {
                            $amount = 0;
                        } else if ($row->transaction_type == 'money_return') {
                            $amount = 0;
                        } else {
                            $amount = $firstOpeningData->amount ?? 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    } else {
                        if ($row->type == 'previous_due') {
                            $amount = 0;
                        } else if ($row->type == 'return') {
                            $amount = 0;
                        } else if ($row->transaction_type == 'money_return') {
                            $amount = 0;
                        } else {
                            $amount = $row->amount ?? 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    }
                })


                ->addColumn('money_return', function ($row) use ($firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {
                        if ($row->type == 'return') {
                            $amount = $row->amount;
                        } else {
                            $amount = 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    } else {
                        if ($row->type == 'return') {
                            $amount = $row->amount;
                        } else if ($row->transaction_type == 'money_return') {
                            $amount = 0;
                        } else {
                            $amount = 0;
                        }
                        return str_replace(',', '', number_format($amount, 2));
                    }
                })
                ->addColumn('balance', function ($row) use (&$balance, $openingBalance, $firstOpeningData) {
                    $checkIf = $firstOpeningData->date ?? null;
                    if ($checkIf != null && $firstOpeningData->date == $row->date) {

                        $balance += $openingBalance;
                        return $balance;
                    } else {
                        $purchaseBill = 0;
                        $receiveOrCredit = 0;
                        $returnAmount = 0;
                        $moneyReturn = 0;

                        if ($row->type == 'previous_due') {
                            $purchaseBill = $row->amount;
                        } else if ($row->transaction_type == 'money_return') {
                            $purchaseBill = 0;
                            $returnAmount = 0;
                        } else if ($row->type == 'return') {
                            $purchaseBill = 0;
                            $returnAmount = 0;
                            $moneyReturn = $row->amount ?? 0;
                        } else if ($row->transaction_type == 'invoice') {
                            $purchaseBill = $row->invoice->grand_total ?? 0;
                        } else if ($row->transaction_type == 'deposit' && $row->type == "deposit") {
                            $receiveOrCredit = $row->amount ?? 0;
                        } else if ($row->type == 'cost') {
                            $purchaseBill = $row->amount ?? 0;
                        }

                        $receiveOrCredit = ($row->type == 'previous_due' || $row->type == 'return') ? 0 : $row->amount ?? 0;
                        if ($row->transaction_type == 'money_return') {
                            $thisBalance = ($purchaseBill - $returnAmount) - ($receiveOrCredit - $moneyReturn);
                        } else if ($row->type == 'invoice') {
                            $thisBalance = $purchaseBill - $receiveOrCredit;
                        } else if ($row->type == 'deposit') {
                            $thisBalance = ($purchaseBill - $moneyReturn) - $receiveOrCredit;
                        } else if ($row->transaction_type == 'invoice' && $row->type == 'deposit') {
                            $thisBalance = ($purchaseBill - $moneyReturn) - $receiveOrCredit;
                        } else {
                            $thisBalance = ($purchaseBill - $returnAmount) + $moneyReturn;
                        }
                        $balance += $thisBalance;

                        return str_replace(',', '', number_format($balance, 2));
                    }
                })
                ->addColumn('description', function ($row) {
                    if ($row->transaction_type == 'deposit') {
                        return __('messages.collection');
                    } else if ($row->transaction_type == 'adjustment') {
                        return __('messages.balance_adjustment');
                    } else if ($row->transaction_type == 'money_return') {
                        $description = [];
                        foreach ($row->invoice->invoiceItems ?? [] as $item) {
                            $description[] = $item->description ?? 'N/A';
                        }
                        return implode('<br><hr class="m-0 bg-danger"> ', $description);
                    } else if ($row->transaction_type == 'invoice') {
                        $description = [];
                        foreach ($row->invoice->invoiceItems ?? [] as $item) {
                            $description[] = $item->description ?? 'N/A';
                        }
                        return implode('<br><hr class="m-0 bg-danger"> ', $description);
                    } else {
                        return $row->description;
                    }
                })

                ->addColumn('labour_cost', function ($row) {
                    return $row->invoice->labour_cost ?? 0;
                })
                ->rawColumns(['source', 'referrer', 'description', 'product', 'unit_id', 'quantity', 'price'])
                ->make(true);
        }
        return view('user.client.statements', compact('pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = __('messages.edit') . ' ' . __('messages.client');
        $client = Client::findOrfail($id);
        return view('user.client.create', compact('pageTitle', 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $account = Account::where('deleted_at', null)->first();
            if ($account == null) {
                alert('No account found!', 'Please create an account first it\'s related to the customer!', 'warning');
                return redirect()->route('user.account.create');
            }
            $client = Client::findOrFail($id);
            // Upload client image
            $file = new FileManager();
            if ($request->image) {
                if ($client->image != null) {
                    Storage::disk('profile')->delete($client->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('client-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = $client->image;
            }
            // Upload client image

            $client->update($request->except('_token', '_method'));
            $client->image = $image; // set image name into staff image field
            $client->updated_by = Auth::user()->username;
            $client->save();
            $transaction = Transaction::where('client_id', $id)->where('type', 'previous_due')->first() ?? null;
            if ($transaction == null) {
                $account = Account::where('deleted_at', null)->first();
                if ($account == null) {
                    alert('No account found!', 'Please create an account first it\'s related to the customer!', 'warning');
                    return redirect()->route('user.account.create');
                }
                $this->adjustBalance($account->id, 'cost', $request->previous_due);
                $balance = $account->account_balance;

                Transaction::create([
                    'description' => "Previous due",
                    'date' => date('Y-m-d', strtotime($client->created_at)),
                    'type' => 'previous_due',
                    'transaction_type' => 'previous_due',
                    'amount' => $client->previous_due ?? 0,
                    'current_balance' => $balance, // Initialize balance with previous due amount
                    'current_due' => $client->previous_due ?? 0, // Initialize balance with previous due amount
                    'client_id' => $client->id,
                    'account_id' => 1,
                    'created_by' => Auth::user()->username,
                ]);
            } else {
                $account = Account::where('id', $transaction->account_id)->first() ?? Account::where('deleted_at', null)->first();
                if ($account == null) {
                    alert('No account found!', 'Please create an account first it\'s related to the customer!', 'warning');
                    return redirect()->route('user.account.create');
                };
                $accountId = $account->id ?? 1;
                $this->adjustBalance($accountId, 'cost', $request->amount, $transaction->amount);
                $balance = $account->account_balance;

                $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $id) + $transaction->amount;
                $currentDue = $clientDue - $request->amount;

                $transaction->update([
                    'amount' => $client->previous_due ?? 0,
                    'current_balance' => $balance, // Initialize balance with previous due amount
                    'current_due' => $currentDue, // Initialize balance with previous due amount
                    'updated_by' => Auth::user()->username,
                ]);
            }
            updateClientBalances($client->id);
            DB::commit();

            toast('Client updated Successfully!', 'success', 'bottom-right');
            if ($request->type == 'modal') {
                return response()->json($client);
            } else {
                return redirect()->route('user.client.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $client = Client::with('invoices')->findOrFail($id);
        if ($client->invoices->count() > 0) {
            return response()->json(['error' => 'This client has invoices. Please delete the invoices first!'], 200);
        }
        // foreach ($client->invoices as $invoice) {
        //     $this->deleteLog(Invoice::class, $invoice->id);
        // }

        foreach ($client->transactions as $transaction) {
            $this->deleteLog(Transaction::class, $transaction->id);
        }

        $this->deleteLog(Client::class, $client->id);

        if (request()->ajax()) {
            return response()->json(['message' => 'Client deleted successfully!']);
        } else {
            toast('Client Deleted Successfully!', 'error', 'top-right');
            return redirect()->back();
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $this->validate($request, [
                'image' => ['required', 'mimes:png,jpg']
            ]);
            $client = Client::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($client->image != null) {
                    Storage::disk('profile')->delete($client->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('client-profile')->upload($photo) ? $client->image = $file->getName() : null;
            }
            $client->save();

            DB::commit();

            toastr()->success("Profile Picture Updated Successfully.", "Success!");
            return redirect()->route('user.client.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage(), "Error!");
            return redirect()->route('user.client.index');
        }
    }

    public function activeToggle(string $id)
    {
        $client = Client::findOrfail($id);
        if ($client->status == 1) {
            $client->status = 0;
        } else {
            $client->status = 1;
        }
        $client->save();
        return response()->json($client);
    }

    public function addAdjustBalance($id)
    {
        try {
            DB::beginTransaction();

            $client = Client::findOrfail($id);
            $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $id);
            if ($previousDue < request()->adjustment_amount) {
                return response()->json(['error' => 'Can\'t adjust over amount!'], 200);
            } else {
                Transaction::create([
                    'description' => "Balance Adjustment",
                    'date' => date('Y-m-d H:i:s'),
                    'type' => 'deposit',
                    'transaction_type' => 'adjustment',
                    'amount' => request()->adjustment_amount ?? 0,
                    'current_balance' => 0, // Initialize balance with previous due amount
                    'current_due' => $previousDue - request()->adjustment_amount, // Initialize balance with previous due amount
                    'client_id' => $client->id,
                    'account_id' => Account::first()->id ?? Account::withTrashed()->first()->id ?? 1,
                    'created_by' => Auth::user()->username,
                ]);
                updateClientBalances($client->id);
                DB::commit();
                return response()->json(['message' => 'Balance adjusted successfully!'], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    public function getAdjustBalance($id)
    {
        try {
            $data = Transaction::where('transaction_type', 'adjustment')->where('client_id', $id)->get();
            foreach ($data as $key => $value) {
                $value['date'] = enDateFormat($value->date);
            }
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function editAdjustBalance($id)
    {
        try {
            $data = Transaction::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    public function updateAdjustBalance($id)
    {
        try {
            DB::beginTransaction();

            $adjust = Transaction::findOrFail($id);
            $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $adjust->client_id) + $adjust->amount;
            if ($previousDue < request()->adjustment_amount) {
                return response()->json(['error' => 'Can\'t adjust over amount!'], 200);
            } else {
                $adjust->description = "Balance Adjustment";
                $adjust->date = date('Y-m-d H:i:s');
                $adjust->type = 'deposit';
                $adjust->transaction_type = 'adjustment';
                $adjust->amount = request()->adjustment_amount ?? 0;
                $adjust->current_balance = 0; // Initialize balance with previous due amoun;
                $adjust->current_due = $previousDue - request()->adjustment_amount; // Initialize balance with previous due amoun;
                $adjust->account_id = Account::first()->id ?? Account::withTrashed()->first()->id ?? 1;
                $adjust->created_by = Auth::user()->username;
                $adjust->save();

                updateClientBalances($adjust->client_id);
                DB::commit();
                return response()->json(['message' => 'Balance adjust updated successfully!'], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    public function destroyAdjustBalance($id)
    {
        try {
            DB::beginTransaction();
            $data = Transaction::findOrFail($id);
            $clientId = $data->client_id;
            $this->deleteLog(Transaction::class, $id);

            updateClientBalances($clientId);
            DB::commit();
            return response()->json(['message' => 'Balance adjust updated successfully!'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    public function remainingDueDate(string $id)
    {
        $data = Client::findOrfail($id);
        $data['remaining_due_date'] = $data->remaining_due_date ? enToBnDate($data->remaining_due_date) : '';
        return response()->json($data);
    }
    public function updateRemainingDueDate(string $id)
    {
        $data = Client::findOrfail($id);
        $data->remaining_due_date = request()->remaining_due_date ? bnToEnDate(request()->remaining_due_date) : null;
        $data->save();
        return response()->json($data);
    }
}
