<?php

namespace App\Http\Controllers\User;

use App\DataTables\PurchaseStatementsDataTable;
use App\DataTables\SupplierDataTable;
use App\Helpers\FileManager;
use App\Helpers\SupplierBalanceHelper;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Account;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SupplierDataTable $dataTable)
    {
        $pageTitle = __('messages.supplier') . ' ' . __('messages.list');
        return $dataTable->render('user.supplier.index', compact('pageTitle'));
    }

    public function remainingDueList(SupplierDataTable $dataTable)
    {
        $pageTitle = __('messages.supplier_remaining_due_date');
        return $dataTable->render('user.supplier.due-list', compact('pageTitle'));
    }

    public function statements(PurchaseStatementsDataTable $dataTable)
    {
        $pageTitle = __('messages.supplier') . ' ' . __('messages.statement');
        return $dataTable->render('user.supplier.statements', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.supplier') . ' ' . __('messages.create');
        return view('user.supplier.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();
            $account = Account::where('deleted_at', null)->first();
            if ($account == null) {
                alert('No account found!', 'Please create an account first it\'s related to the supplier!', 'warning');
                return redirect()->route('user.account.create');
            }
            // Upload supplier image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload supplier image

            $supplier = new Supplier($request->all());
            $supplier->image = $image; // set image name into staff image field
            $supplier->created_by = Auth::user()->username;
            $supplier->save();

            $account = Account::first() ?? 1;
            $accountId = $account->id ?? 1;
            $this->adjustBalance($accountId, 'cost', $request->previous_due);
            $balance = $account->account_balance;

            Transaction::create([
                'description' => "Previous due",
                'date' => date('Y-m-d', strtotime($supplier->created_at)),
                'type' => 'previous_due',
                'transaction_type' => 'previous_due',
                'amount' => $supplier->previous_due ?? 0,
                'current_balance' => $balance, // Initialize balance with previous due amount
                'current_due' => $supplier->previous_due ?? 0, // Initialize balance with previous due amount
                'supplier_id' => $supplier->id,
                'account_id' => 1,
                'created_by' => Auth::user()->username,
            ]);
            DB::commit();
            updateSupplierBalances($supplier->id);
            toast('Supplier Added Successfully!', 'success', 'bottom-right');
            if (request()->ajax()) {
                return response()->json($supplier);
            } else {
                return redirect()->route('user.supplier.index');
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
        $supplier = Supplier::findOrFail($id);
        $supplier['group_name'] = $supplier->group->name ?? '---';
        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pageTitle = __('messages.edit') . ' ' . __('messages.suppplier');
        $supplier = Supplier::findOrFail($id);
        return view('user.supplier.create', compact('pageTitle', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $account = Account::where('deleted_at', null)->first();
            if ($account == null) {
                alert('No account found!', 'Please create an account first it\'s related to the customer!', 'warning');
                return redirect()->route('user.account.create');
            }
            // Upload supplier image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload supplier image

            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->except('_token', '_method'));
            $supplier->image = $image; // set image name into staff image field
            $supplier->created_by = Auth::user()->username;
            $supplier->save();

            $transaction = Transaction::where('supplier_id', $id)->where('type', 'previous_due')->first() ?? null;
            if ($transaction == null) {
                $account = Account::where('deleted_at', null)->first();
                $this->adjustBalance($account->id, 'cost', $request->previous_due);
                $balance = $account->account_balance;

                Transaction::create([
                    'description' => "Previous due",
                    'date' => date('Y-m-d', strtotime($supplier->created_at)),
                    'type' => 'previous_due',
                    'transaction_type' => 'previous_due',
                    'amount' => $supplier->previous_due ?? 0,
                    'current_balance' => $balance, // Initialize balance with previous due amount
                    'current_due' => $supplier->previous_due ?? 0, // Initialize balance with previous due amount
                    'supplier_id' => $id,
                    'account_id' => 1,
                    'created_by' => Auth::user()->username,
                ]);
            } else {
                $account = Account::findOrFail($transaction->account_id) ?? 1;
                $accountId = $account->id ?? 1;
                $this->adjustBalance($accountId, 'cost', $request->amount, $transaction->amount);
                $balance = $account->account_balance;

                $supplierDue = SupplierBalanceHelper::getTotalDue(Transaction::class, $id) + $transaction->amount;
                $currentDue = $supplierDue - $request->amount;

                $transaction->update([
                    'amount' => $supplier->previous_due ?? 0,
                    'current_balance' => $balance, // Initialize balance with previous due amount
                    'current_due' => $currentDue, // Initialize balance with previous due amount
                    'supplier_id' => $id, // Initialize balance with previous due amount
                    'updated_by' => Auth::user()->username,
                ]);
            }

            DB::commit();
            updateSupplierBalances($supplier->id);
            toast('Supplier Updated Successfully!', 'success', 'bottom-right');
            return redirect()->route('user.supplier.index');
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
        $supplier = Supplier::findOrFail($id);

        if ($supplier->purchases->count() > 0) {
            toast('Supplier has transactions! Please delete the transactions first!', 'warning');
            return redirect()->back();
        }

        foreach ($supplier->purchases as $purchase) {
            $this->deleteLog(Purchase::class, $purchase->id);
        }
        $this->deleteLog(Supplier::class, $id);

        toast('Supplier Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }

    public function updateImage(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'image' => ['required', 'mimes:png,jpg']
            ], [
                'image.required' => 'Please select an image first.'
            ]);
            $supplier = Supplier::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($supplier->image != null) {
                    Storage::disk('profile')->delete($supplier->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $supplier->image = $file->getName() : null;
            }
            $supplier->save();
            DB::commit();
            toastr()->success("Profile Picture Updated Successfully.", "Success!");
            return redirect()->route('user.supplier.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage(), "Error!");
            return redirect()->route('user.supplier.index');
        }
    }

    public function remainingDueDate(string $id)
    {
        $data = Supplier::findOrfail($id);
        $data['remaining_due_date'] = $data->remaining_due_date != null ? enToBnDate($data->remaining_due_date) : '';
        return response()->json($data);
    }
    public function updateRemainingDueDate(string $id)
    {
        $data = Supplier::findOrfail($id);
        $data->remaining_due_date = request()->date ? bnToEnDate(request()->date) : null;
        $data->save();
        return response()->json($data);
    }
}
