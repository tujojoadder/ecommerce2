<?php

namespace App\Http\Controllers\User\Purchase;

use App\DataTables\PurchaseDataTable;
use App\DataTables\PurchaseInvoiceDataTable;
use App\DataTables\PurchaseReportDataTable;
use App\Helpers\SupplierBalanceHelper;
use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\Traits\InvoiceTrait;
use App\Helpers\Traits\PurchaseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Account;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    use DeleteLogTrait, AccountBalanceTrait, PurchaseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(PurchaseDataTable $dataTable)
    {
        if (request()->routeIs('user.purchase.return')) {
            $pageTitle = __('messages.product') . ' ' . __('messages.wise') . ' ' . __('messages.purchase') . ' ' . __('messages.return') . ' ' . __('messages.list');
        } else {
            $pageTitle = __('messages.product') . ' ' . __('messages.wise') . ' ' . __('messages.purchase') . ' ' . __('messages.list');
        }

        return $dataTable->render('user.purchase.index', compact('pageTitle'));
    }

    public function invoice(PurchaseInvoiceDataTable $dataTable)
    {
        if (request()->routeIs('user.purchase.return.invoice')) {
            $pageTitle = __('messages.purchase') . ' ' . __('messages.return') . ' ' . __('messages.invoice') . ' ' . __('messages.list');
        } else {
            $pageTitle = __('messages.purchase') . ' ' . __('messages.invoice') . ' ' . __('messages.list');
        }
        return $dataTable->render('user.purchase.invoice-wise', compact('pageTitle'));
    }

    public function report(PurchaseReportDataTable $dataTable)
    {
        $supplier_id = $_GET['supplier_id'] ?? null;
        if ($supplier_id !== null) {
            $supplierId = $_GET['supplier_id'];
            $supplier = Supplier::findOrFail($supplierId);
            $pageTitle = __('messages.purchase') . ' ' . __('messages.report') . ' ' . $supplier->supplier_name;
        } else {
            $pageTitle = __('messages.purchase') . ' ' . __('messages.report');
        }
        if (request()->routeIs('user.purchase.return.report')) {
            $pageTitle = __('messages.purchase') . ' ' . __('messages.return') . ' ' . __('messages.report');
        }
        return $dataTable->render('user.purchase.report', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.add_new');
        return view('user.purchase.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequest $request)
    {
        try {
            DB::beginTransaction();

            $purchase = new Purchase();
            $purchase->invoice_id = $request->invoice_id ?? 0;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->stock_id = $request->stock_id;
            $purchase->warehouse_id = $request->warehouse_id;
            $purchase->issued_date = bnToEnDate($request->issued_date);
            $purchase->discount = $request->discount;
            $purchase->discount_type = $request->discount_type ?? 'flat';
            $purchase->transport_fare = $request->transport_fare;
            $purchase->vat_type = $request->vat_type ?? 'flat';
            $purchase->vat = $request->vat;
            $purchase->account_id = $request->account_id;
            $purchase->category_id = $request->category_id;
            $purchase->receive_amount = $request->receive_amount;
            $purchase->purchase_bill = $request->purchase_bill;
            $purchase->total_vat = $request->total_vat;
            $purchase->total_discount = $request->total_discount;
            $purchase->grand_total = $request->grand_total;
            $purchase->total_due = $request->total_due;
            $purchase->created_by = Auth::user()->username;
            $purchase->status = $request->purchase_type == 'return' ? 4 : 0;
            $purchase->save();
            $purchased_id = $purchase->id;
            $purchased_items = $request->purchased_items;
            // add invoice product items to the invoice_items table
            foreach ($purchased_items as $item) {
                $free = $item['free'];
                $quantity = $item['quantity'];
                if (empty($item['quantity'])) {
                    $quantity = 0;
                }
                if (empty($item['free'])) {
                    $free = 0;
                }
                $total_quantity = $quantity + $free;

                $product = Product::findOrFail($item['product_id']);
                $purchaseItem = PurchaseItem::create([
                    'purchase_id' => $purchased_id,
                    'issued_date' => $purchase->issued_date,
                    'row_id' => $item['row_id'],
                    'product_id' => $item['product_id'],
                    'unit_id' => $item['unit_id'] ?? $product->unit_id,
                    'description' => $item['description'],
                    'selling_price' => $item['selling_price'],
                    'free' => $free,
                    'quantity' => $total_quantity,
                    'return_type' => $item['return_type'],
                    'buying_price' => $item['buying_price'],
                    'total_buying_price' => $item['total_buying_price'],
                    'total_selling_price' => $item['total_selling_price'],
                    'wholesale_price' => $item['wholesale_price'],
                    'barcode_id' => $item['barcode_id'],
                    'created_by' => Auth::user()->username,
                    'status' => $purchase->status,
                ]);
                setCurrentStock($purchaseItem->product_id);
            }
            toast('Purchased Successfully!', 'success');

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->receive_amount);
            $balance = $account->account_balance;

            $data = new Transaction();
            $data->type = $request->purchase_type == 'return' ? 'deposit' : 'cost';
            $data->transaction_type = $request->purchase_type == 'return' ? 'purchase_return' : 'purchase';
            $data->supplier_id = $request->supplier_id;
            $data->invoice_id = null;
            $data->purchase_id = $purchased_id;
            $data->date = bnToEnDate($request->issued_date);
            $data->account_id = $request->account_id;
            $data->description = $request->description;
            $data->amount = $request->receive_amount;
            $data->current_balance = $balance;
            $data->category_id = $request->category_id;
            $data->send_sms = $request->send_sms;
            $data->send_email = $request->send_email;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            foreach ($purchased_items as $item) {
                setProductStock($item['product_id']);
            }

            updateSupplierBalances($purchase->supplier_id);
            toast('Account Balance Increase up!', 'success');
            return response()->json($purchase);
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
        $pageTitle = "Purchase";
        $purchase = Purchase::with('purchaseItems')->findOrFail($id);
        $payment = $this->purchasePayment($id);
        $due = $this->purchaseDue($id);
        $supplierDue = SupplierBalanceHelper::getTotalDue(Transaction::class, $purchase->supplier_id);
        $totalBill = $purchase->grand_total;
        $totalDue = $totalBill - $payment;
        return view('user.purchase.view', compact('purchase', 'pageTitle', 'payment', 'due', 'supplierDue', 'totalBill', 'totalDue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function goToEdit(string $id)
    {
        $pageTitle = __('messages.edit') . ' ' . __('messages.purchase');
        $purchase = Purchase::findOrFail($id);
        return view('user.purchase.edit', compact('purchase', 'pageTitle'));
    }

    public function edit(string $id)
    {
        $data = Purchase::findOrFail($id);
        $data['issued_date'] = enToBnDate($data->issued_date);
        $data['supplier_name'] = $data->supplier->supplier_name ?? '';
        $data['purchased_items'] = PurchaseItem::with(['unit', 'product'])->where('purchase_id', $data->id)->get();
        // foreach ($data['purchased_items'] as $key => $item) {
        //     $item->unit_name = $item->unit->name ?? '';
        // }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $purchase = Purchase::findOrfail($id);
            $purchase->invoice_id = $request->invoice_id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->stock_id = $request->stock_id;
            $purchase->warehouse_id = $request->warehouse_id;
            $purchase->issued_date = bnToEnDate($request->issued_date);
            $purchase->discount = $request->discount;
            $purchase->discount_type = $request->discount_type ?? 'flat';
            $purchase->transport_fare = $request->transport_fare;
            $purchase->vat_type = $request->vat_type ?? 'flat';
            $purchase->vat = $request->vat;
            $purchase->account_id = $request->account_id;
            $purchase->category_id = $request->category_id;
            $purchase->receive_amount = $request->receive_amount;
            $purchase->purchase_bill = $request->purchase_bill;
            $purchase->total_vat = $request->total_vat;
            $purchase->total_discount = $request->total_discount;
            $purchase->grand_total = $request->grand_total;
            $purchase->total_due = $request->total_due;
            $purchase->updated_by = Auth::user()->username;
            $purchase->save();

            // Update or insert invoice items
            $purchaseItems = PurchaseItem::where('purchase_id', $purchase->id)->get();
            foreach ($purchaseItems as $item) {
                $purchaseItem = PurchaseItem::findOrFail($item->id);
                $purchaseItem->forceDelete();
            }

            $purchased_items = $request->purchased_items;
            foreach ($purchased_items as $item) {
                $free = $item['free'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                $return_quantity = $item['return_quantity'] ?? 0;

                $total_quantity = $quantity + $free;

                $product = Product::findOrFail($item['product_id']);
                $purchaseItemData = [
                    'purchase_id' => $purchase->id,
                    'issued_date' => $purchase->issued_date,
                    'row_id' => $item['row_id'],
                    'product_id' => $item['product_id'],
                    'unit_id' => $item['unit_id'] ?? $product->unit_id,
                    'description' => $item['description'],
                    'selling_price' => $item['selling_price'],
                    'free' => $free,
                    'quantity' => $total_quantity,
                    'return_type' => $item['return_type'],
                    // 'return_quantity' => $return_quantity,
                    'buying_price' => $item['buying_price'],
                    'total_buying_price' => $item['total_buying_price'],
                    'total_selling_price' => $item['total_selling_price'],
                    'wholesale_price' => $item['wholesale_price'],
                    'barcode_id' => $item['barcode_id'],
                    'created_by' => Auth::user()->username,
                    'status' => $purchase->status,
                ];
                $purchaseItem = PurchaseItem::create($purchaseItemData);
            }

            $transaction = Transaction::whereIn('transaction_type', ['purchase', 'purchase_return'])->where('purchase_id', $id)->first();

            $account = Account::findOrFail($request->account_id);
            $this->adjustBalance($account->id, 'cost', $request->receive_amount, $purchase->amount);
            $balance = $account->account_balance;

            $purchaseDue = $this->purchaseDue($id) + ($transaction->amount ?? 0);
            $currentDue = $request->amount - $purchaseDue;

            $transaction = Transaction::findOrFail($transaction->id);
            $transaction->supplier_id = $purchase->supplier_id;
            $transaction->amount = $request->receive_amount;
            $transaction->date = bnToEnDate($request->issued_date);
            $transaction->current_due = $currentDue;
            $transaction->current_balance = $balance;
            $transaction->category_id = $request->category_id;
            $transaction->send_sms = $request->send_sms;
            $transaction->send_email = $request->send_email;
            $transaction->updated_by = Auth::user()->username;
            $transaction->save();

            DB::commit();

            foreach ($purchased_items as $item) {
                setProductStock($item['product_id']);
            }

            updateSupplierBalances($purchase->supplier_id);
            return response()->json($purchase);
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
        $purchase = Purchase::findOrFail($id);
        $supplier_id = $purchase->supplier_id;
        $product_ids = [];
        foreach ($purchase->purchaseItems as $item) {
            $product_ids[] = $item->product_id;
            $this->deleteLog(PurchaseItem::class, $item->id);
        }
        $transactions = Transaction::where('purchase_id', $id)->get();
        foreach ($transactions as $transaction) {
            $this->deleteLog(Transaction::class, $transaction->id);
        }
        $this->deleteLog(Purchase::class, $id);

        foreach ($product_ids as $product_id) {
            setProductStock($product_id);
        }

        updateSupplierBalances($supplier_id);

        toast('Purchased Item Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }

    public function destroyItem(string $id)
    {
        // $data = PurchaseItem::findOrFail($id)->delete();
        // return response()->json($data);
    }
}
