<?php

namespace App\Http\Controllers\User\Accounts;

use App\DataTables\ExpenseDataTable;
use App\DataTables\StaffsDataTable;
use App\DataTables\SupplierPaymentDataTable;
use App\Helpers\ClientBalanceHelper;
use App\Helpers\FileManager;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\SupplierPaymentRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Supplier;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    use AccountBalanceTrait, DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ExpenseDataTable $dataTable)
    {
        if (request()->has('supplier-payment') || request()->has('create-supplier-payment')) {
            $pageTitle = __('messages.supplier') . ' ' . __('messages.payment') . ' ' . __('messages.list');
        } else if (request()->has('money-return') || request()->has('create-money-return')) {
            $pageTitle = __('messages.money') . ' ' . __('messages.return') . ' ' . __('messages.list');
        } else if (request()->has('create-personal-expense') || request()->has('personal-expnese')) {
            $pageTitle = __('messages.personal_expense') . ' ' . __('messages.list');
        } else if (request()->has('staff-payment')) {
            $pageTitle = __('messages.staff') . ' ' . __('messages.payment') . ' ' . __('messages.list');
        } else {
            $pageTitle = __('messages.expense') . ' ' . __('messages.list');
        }
        return $dataTable->render('user.accounts.expense.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        try {

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->amount);
            $balance = $account->account_balance;

            DB::beginTransaction();
            $data = new Transaction();
            if ($request->transaction_type == 'supplier_payment') {
                $data->type = 'cost';
                $data->transaction_type = 'supplier_payment';
                $data->supplier_id = $request->supplier_id;
                $data->invoice_id = $request->purchase_id;
                $data->purchase_id = $request->purchase_id;
            } else if ($request->transaction_type == 'personal_expense') {
                $data->type = 'cost';
                $data->transaction_type = 'personal_expense';
            } else if ($request->transaction_type == 'daily_expense') {
                $data->type = 'daily_expense';
                $data->transaction_type = 'daily_expense';
            } else if ($request->transaction_type == 'staff_payment') {
                $data->type = 'cost';
                $data->transaction_type = 'staff_payment';
            } else if ($request->transaction_type == 'money_return') {
                $data->type = 'return';
                $data->transaction_type = 'money_return';
                $data->client_id = $request->client_id;

                $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $request->client_id);
                $currentDue = $clientDue - $request->amount;
                $data->current_due = $currentDue;
            } else {
                $data->type = 'cost';
                $data->transaction_type = 'cost';
            }
            // for staff
            $data->staff_id = $request->staff_id;
            $data->month = $request->month;
            $data->year = $request->year;
            // for staff

            $data->date = bnToEnDate($request->date);
            $data->expense_type = $request->expense_type;
            $data->account_id = $request->account_id;
            $data->amount = $request->amount;
            $data->current_balance = $balance;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->payment_id = $request->payment_id;
            $data->bank_id = $request->bank_id;
            $data->cheque_no = $request->cheque_no;
            $data->image = $request->image;
            $data->description = $request->description;
            $data->created_by = Auth::user()->created_by;

            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('company')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('company')->prefix('expense-attachment')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            $data->image = $image;

            $data->save();
            DB::commit();

            if ($request->client_id != NULL) {
                updateClientBalances($request->client_id);
            }

            if ($request->supplier_id != NULL) {
                updateSupplierBalances($request->supplier_id);
            }

            toast('Expense Added Successfully!', 'success');
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
        try {
            $transaction = Transaction::findOrFail($id);

            $receiver_name = 'NULL';
            $receiver_phone = 'NULL';
            $receiver_bank = $transaction->bank->name ?? 'NULL';

            if ($transaction->client_id != NULL) {
                $client = Client::findOrfail($transaction->client_id);
                $receiver_name = $client->client_name;
                $receiver_phone = $client->phone;
            }
            if ($transaction->staff_id != NULL) {
                $staff = User::findOrFail($transaction->staff_id);
                $receiver_name = $staff->name;
                $receiver_phone = $staff->phone;
            }
            if ($transaction->supplier_id != NULL) {
                $supplier = Supplier::findOrFail($transaction->supplier_id);
                $receiver_name = $supplier->supplier_name;
                $receiver_phone = $supplier->phone;
            }

            return view('user.receipt.expense-voucher-modal', compact('transaction', 'receiver_name', 'receiver_phone', 'receiver_bank'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Transaction::findOrFail($id);
            $data['date'] = enToBnDate($data->date);
            $data['client_id'] = $data->client_id;
            $data['client_name'] = $data->client->client_name ?? '';
            return response()->json($data);
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
            DB::beginTransaction();
            $data = Transaction::findOrFail($id);

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->amount, $data->amount);
            $balance = $account->account_balance;

            $data->date = bnToEnDate($request->date);
            $data->expense_type = $request->expense_type;
            $data->account_id = $request->account_id;

            if ($data->transaction_type == 'supplier_payment') {
                $data->supplier_id = $request->supplier_id;
                $data->invoice_id = $request->purchase_id;
                $data->purchase_id = $request->purchase_id;
            } else if ($request->transaction_type == 'personal_expense') {
                $data->type = 'cost';
                $data->transaction_type = 'personal_expense';
            } else if ($request->transaction_type == 'daily_expense') {
                $data->type = 'daily_expense';
                $data->transaction_type = 'daily_expense';
            } else if ($data->transaction_type == 'staff_payment') {
                $data->staff_id = $request->staff_id;
                $data->month = $request->month;
                $data->year = $request->year;
            } else if ($data->transaction_type == 'money_return') {
                $data->type = 'return';
                $data->client_id = $request->client_id;
                updateClientBalances($request->client_id);
            } else {
                $data->type = 'cost';
            }

            // for staff
            $data->staff_id = $request->staff_id;
            $data->month = $request->month;
            $data->year = $request->year;
            // for staff

            $data->amount = $request->amount;
            $data->current_balance = $balance;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->payment_id = $request->payment_id;
            $data->bank_id = $request->bank_id;
            $data->cheque_no = $request->cheque_no;

            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('company')->delete($data->image);
                }
                $photo = $request->image;
                $file->folder('company')->prefix('expense-attachment')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            $data->image = $image;

            $data->image = $request->image;
            $data->description = $request->description;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();
            if ($request->client_id != NULL) {
                updateClientBalances($request->client_id);
            }

            if ($request->supplier_id != NULL) {
                updateSupplierBalances($request->supplier_id);
            }

            toast('Expense Updated Successfully!', 'success');
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
        if ($data->client_id != NULL) {
            $clientId = $data->client_id;
            $this->deleteLog(Transaction::class, $id);
            updateClientBalances($clientId);
        } else {
            $this->deleteLog(Transaction::class, $id);
        }

        toast('Expense Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }

    // ----------------------------------------------------------- staff payment start
    public function staffPayment(SupplierPaymentDataTable $dataTable)
    {
        try {
            $suppliers = Supplier::where('deleted_at', null)->get();
            $categories = ExpenseCategory::where('deleted_at', null)->get();
            $payment_methods = PaymentMethod::where('deleted_at', null)->get();
            $accounts = Account::where('deleted_at', null)->get();
            $banks = Bank::where('deleted_at', null)->get();
            $pageTitle = 'Supplier Payment List';
            return $dataTable->render('user.accounts.expense.supplier-payment', compact('pageTitle', 'suppliers', 'categories', 'payment_methods', 'accounts', 'banks'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function staffPaymentStore(SupplierPaymentRequest $request)
    {
        try {
            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->amount);
            $balance = $account->account_balance;

            $data = new Transaction();
            $data->type = 'cost';
            $data->transaction_type = 'purchase';
            $data->date = bnToEnDate($request->date);
            $data->expense_type = $request->expense_type;
            $data->supplier_id = $request->supplier_id;
            $data->invoice_id = $request->invoice_id;

            $data->current_balance = $balance;

            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->payment_id = $request->payment_id;
            $data->account_id = $request->account_id;
            $data->bank_id = $request->bank_id;
            $data->amount = $request->amount;
            $data->cheque_no = $request->cheque_no;
            $data->description = $request->note;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            toast('Expense Added Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function staffPaymentUpdate(SupplierPaymentRequest $request)
    {
        try {
            $data = Transaction::findOrFail($request->id);

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->amount, $data->amount);
            $balance = $account->account_balance;

            $data->date = bnToEnDate($request->date);
            $data->expense_type = $request->expense_type;
            $data->supplier_id = $request->supplier_id;
            $data->invoice_id = $request->purchase_id;
            $data->category_id = $request->category_id;
            $data->payment_id = $request->payment_id;
            $data->account_id = $request->account_id;
            $data->bank_id = $request->bank_id;
            $data->amount = $request->amount;
            $data->cheque_no = $request->cheque_no;
            $data->description = $request->note;

            $data->current_balance = $balance;
            $data->save();

            toast('Supplier Payment Updated Successfully!', 'success');

            return response()->json($data);
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
    // ----------------------------------------------------------- staff payment start

    public function clientLoan(StaffsDataTable $dataTable)
    {
        try {
            $pageTitle = __('messages.client') . ' ' . __('messages.loan') . ' ' . __('messages.list');
            return $dataTable->render('user.accounts.expense.client-loan', compact('pageTitle'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }


    public function clientMoneyReturn(StaffsDataTable $dataTable)
    {
        try {
            $pageTitle = __('messages.client') . ' ' . __('messages.money') . ' ' . __('messages.return');
            return $dataTable->render('user.accounts.expense.client-money-return', compact('pageTitle'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
