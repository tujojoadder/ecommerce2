<?php

namespace App\Http\Controllers\User;

use App\Helpers\Traits\AccountBalanceTrait;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BulkManagementController extends Controller
{
    use AccountBalanceTrait;
    public function index()
    {
        return view('user.bulk-upload-modal');
    }
    public function uploadJson(Request $request)
    {
        $request->validate([
            'bulk_file' => 'required|mimes:json',
        ]);
        $filePath = $request->file('bulk_file')->getPathname();

        // Check if the file exists
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found!'], 404);
        }

        // Load and decode JSON data
        $jsonData = file_get_contents($filePath);
        $invoices = json_decode($jsonData, true);
        foreach ($invoices as $invoice) {
            $invoiceObj = $this->invoiceInsert($invoice);
            foreach ($invoice['invoice_items'] as $key => $item) {
                $product = Product::where('name', $item['product'])->first();
                if (!$product) {
                    $product = Product::create([
                        'name' => $item['product'],
                        'buying_price' => $item['buying_price'] ?? 0,
                        'selling_price' => $item['selling_price'] ?? 0,
                        'unit_id' => ProductUnit::whereIn('name', ['PCS', 'pcs'])->first()->id,
                        'opening_stock' => 0,
                        'stock_warning' => 0,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                }
                InvoiceItem::insert([
                    "issued_date" => $invoiceObj->issued_date,
                    "invoice_id" => $invoiceObj->id,
                    "purchased_id" => null,
                    "row_id" => $key,
                    "product_id" => $product->id,
                    "description" => $product->description,
                    "stock" => $product->in_stock,
                    "buying_price" => $product->buying_price,
                    "selling_price" => $item['selling_price'] === "NULL" ? $product->selling_price : $item['selling_price'],
                    "quantity" => $item['quantity'] === "NULL" ? 1 : $item['quantity'],
                    "return_type" => null,
                    "return_quantity" => 0,
                    "unit_id" => $product->unit_id,
                    "total" => $item['quantity'] === "NULL" ? 1 : $item['quantity'] * ($item['selling_price'] ?? $product->selling_price),
                    "status" => 0,
                    "created_by" => Auth::user()->username,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        toastr()->success('Json file uploaded and data inserted successfully.', 'Success!');
        return redirect()->back();
    }
    // public function uploadExcel(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'type' => 'required|string',
    //             'bulk_file' => 'required|mimes:xlsx,xls',
    //             'bulk_parent_file' => 'mimes:xlsx,xls',
    //         ]);
    //         $file = $request->file('bulk_file');
    //         $spreadsheet = IOFactory::load($file->getPathname());
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $rows = $sheet->toArray();
    //         foreach ($rows as $index => $row) {
    //             if ($index === 0) {
    //                 continue; // Skip the header row
    //             }
    //             if ($request->type == 'products') {
    //                 $this->productInsert($row);
    //             }
    //             if ($request->type == 'invoices') {
    //                 $this->invoiceInsert($row);
    //             }
    //             if ($request->type == 'purchases') {
    //                 $this->purchaseInsert($row);
    //             }
    //         }
    //         if ($request->type == 'invoices' || $request->type == 'purchases') {
    //             $parentFile = $request->file('bulk_parent_file');
    //             $itemsSpreadsheet = IOFactory::load($parentFile->getPathname());
    //             $parentSheet = $itemsSpreadsheet->getActiveSheet();
    //             $parentRows = $parentSheet->toArray();

    //             foreach ($parentRows as $index => $row) {
    //                 if ($index === 0) {
    //                     continue; // Skip the header row
    //                 }
    //                 if ($request->type == 'invoices') {
    //                     $this->invoiceItemsInsert($row);
    //                 }
    //                 if ($request->type == 'purchases') {
    //                     $this->purchaseItemsInsert($row);
    //                 }
    //             }
    //         }

    //         toastr()->success('Excel file uploaded and data inserted successfully.', 'Success!');
    //         return redirect()->back();
    //     } catch (\Throwable $th) {
    //         toastr()->error('Error occurred while uploading Excel file.', 'Error!');
    //         toastr()->error($th->getMessage(), 'Error!');
    //         return redirect()->back();
    //     }
    // }

    public function productInsert($row)
    {
        try {
            DB::beginTransaction();
            Product::insert([
                'name' => $row[1] === "NULL" ? null : $row[1],
                'image' => null,
                'description' => $row[3] === "NULL" ? null : $row[3],
                'buying_price' => $row[4] === "NULL" ? null : $row[4],
                'selling_price' => $row[5] === "NULL" ? null : $row[5],
                'wholesale_price' => $row[6] === "NULL" ? null : $row[6],
                'unit_id' => $row[7] === "NULL" ? null : $row[7],
                'opening_stock' => $row[8] === "NULL" ? null : $row[8],
                'carton' => $row[9] === "NULL" ? null : $row[9],
                'group_id' => $row[10] === "NULL" ? null : $row[10],
                'stock_warning' => $row[11] === "NULL" ? null : $row[11],
                'color_id' => $row[12] === "NULL" ? null : $row[12],
                'size_id' => $row[13] === "NULL" ? null : $row[13],
                'brand_id' => $row[14] === "NULL" ? null : $row[14],
                'warehouse_id' => $row[15] === "NULL" ? null : $row[15],
                'custom_barcode_no' => $row[16] === "NULL" ? null : $row[16],
                'imei_no' => $row[17] === "NULL" ? null : $row[17],
                'status' => $row[18] === "NULL" ? null : $row[18],
                'created_by' => Auth::user()->username,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function invoiceInsert($row)
    {
        try {
            $date = DateTime::createFromFormat('d/m/Y H:i', $row['issued_date']);
            $formattedDate = $date->format('Y-m-d H:i:s');
            $client = Client::where('client_name', $row['client_name'])->first();
            DB::beginTransaction();
            if (!$client) {
                $client = Client::create([
                    'client_name' => $row['client_name'],
                    'created_by' => Auth::user()->username,
                ]);

                $account = Account::first();
                $balance = $account->account_balance;

                Transaction::insert([
                    'description' => "Previous due",
                    'date' => $formattedDate ?? now(),
                    'type' => 'previous_due',
                    'transaction_type' => 'previous_due',
                    'amount' => $client->previous_due ?? 0,
                    'current_balance' => $balance,
                    'current_due' => $client->previous_due ?? 0,
                    'client_id' => $client->id,
                    'account_id' => $account->id,
                    'created_by' => Auth::user()->username,
                ]);
            }
            $invoice = Invoice::create([
                "client_id" => $client->id,
                "issued_date" => $formattedDate ?? now(),
                "issued_time" => date('H:i:s'),
                "discount_type" => $row['discount_type'] === "NULL" ? 'flat' : $row['discount_type'],
                "discount" => $row['total_discount'] === "NULL" ? 0 : $row['total_discount'],
                "total_return" => 0,
                "transport_fare" => $row['transport_fare'] === "NULL" ? 0 : $row['transport_fare'],
                "labour_cost" => $row['labour_cost'] === "NULL" ? 0 : $row['labour_cost'],
                "account_id" => $row['account_id'] === "NULL" ? NULL : $row['account_id'],
                "bank_id" => null,
                "cheque_number" => null,
                "cheque_issued_date" => null,
                "category_id" => null,
                "receive_amount" => $row['receive_amount'] === "NULL" ? 0 : $row['receive_amount'],
                "cash_receive" => $row['cash_receive'] ?? 0,
                "change_amount" => $row['change_amount'] ?? 0,
                "bill_amount" => $row['bill_amount'] === "NULL" ? 0 : $row['bill_amount'],
                "due_amount" => $row['due_amount'] === "NULL" ? 0 : $row['due_amount'],
                "highest_due" => 0,
                "vat_type" => $row['vat_type'] === "NULL" ? 'flat' : $row['vat_type'],
                "vat" => $row['total_vat'] === "NULL" ? 0 : $row['total_vat'],
                "description" => null,
                "track_number" => $row['no'] === "NULL" ? null : $row['no'],
                "total_discount" => $row['total_discount'] === "NULL" ? 0 : $row['total_discount'],
                "previous_due" => $client->previous_due,
                "total_vat" => $row['total_vat'] === "NULL" ? 0 : $row['total_vat'],
                "grand_total" => $row['grand_total'] === "NULL" ? 0 : $row['grand_total'],
                "total_due" => $row['total_due'] === "NULL" ? 0 : $row['total_due'],
                'created_by' => Auth::user()->username,
            ]);

            $account = Account::findOrFail($invoice->account_id);
            $this->adjustBalance($account->id, 'deposit', $invoice->receive_amount);
            $balance = $account->account_balance;

            $currentDue = $invoice->grand_total - $invoice->receive_amount;

            $data = new Transaction();
            $data->type = 'deposit';
            $data->transaction_type = 'invoice';
            $data->client_id = $invoice->client_id;
            $data->invoice_id = $invoice->id;
            $data->date = $invoice->issued_date;
            $data->account_id = $invoice->account_id;
            $data->description = $invoice->description;
            $data->amount = $invoice->receive_amount;
            $data->current_due = $currentDue;
            $data->current_balance = $balance;
            $data->category_id = $invoice->category_id;
            $data->send_sms = $invoice->send_sms;
            $data->send_email = $invoice->send_email;
            $data->created_by = Auth::user()->username;
            $data->save();
            DB::commit();
            return $invoice;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function purchaseInsert($row)
    {
        try {
            DB::beginTransaction();
            $purchase = Purchase::create([
                "id" => $row[0] === "NULL" ? NULL : $row[0],
                "invoice_id" => $row[1] === "NULL" ? NULL : $row[1],
                "supplier_id" => $row[2] === "NULL" ? NULL : $row[2],
                "warehouse_id" => $row[3] === "NULL" ? NULL : $row[3],
                "issued_date" => $row[4] === "NULL" ? NULL : bnToEnDate(date('d/m/Y', strtotime($row[4]))),
                "discount" => $row[5] === "NULL" ? NULL : $row[5],
                "discount_type" => $row[6] === "NULL" ? NULL : $row[6],
                "transport_fare" => $row[7] === "NULL" ? NULL : $row[7],
                "vat_type" => $row[8] === "NULL" ? NULL : $row[8],
                "vat" => $row[9] === "NULL" ? NULL : $row[9],
                "account_id" => $row[10] === "NULL" ? NULL : $row[10],
                "category_id" => $row[11] === "NULL" ? NULL : $row[11],
                "receive_amount" => $row[12] === "NULL" ? NULL : $row[12],
                "purchase_bill" => $row[13] === "NULL" ? NULL : $row[13],
                "total_vat" => $row[14] === "NULL" ? NULL : $row[14],
                "total_discount" => $row[15] === "NULL" ? NULL : $row[15],
                "grand_total" => $row[16] === "NULL" ? NULL : $row[16],
                "total_due" => $row[17] === "NULL" ? NULL : $row[17],
                'created_by' => Auth::user()->username
            ]);

            $account = Account::findOrFail($purchase->account_id);
            $this->adjustBalance($account->id, 'cost', $purchase->receive_amount);
            $balance = $account->account_balance;

            $data = new Transaction();
            $data->type = 'cost';
            $data->transaction_type = 'purchase';
            $data->supplier_id = $purchase->supplier_id;
            $data->invoice_id = null;
            $data->purchase_id = $purchase->id;
            $data->date = $purchase->issued_date;
            $data->account_id = $purchase->account_id;
            $data->description = $purchase->description;
            $data->amount = $purchase->receive_amount;
            $data->current_balance = $balance;
            $data->category_id = $purchase->category_id;
            $data->send_sms = $purchase->send_sms ?? false;
            $data->send_email = $purchase->send_email ?? false;
            $data->created_by = Auth::user()->username;
            $data->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function purchaseItemsInsert($row)
    {
        try {
            DB::beginTransaction();
            PurchaseItem::insert([
                "issued_date" => $row[1] === "NULL" ? NULL : bnToEnDate(date('d/m/Y', strtotime($row[1]))),
                "purchase_id" => $row[2] === "NULL" ? NULL : $row[2],
                "row_id" => $row[3] === "NULL" ? NULL : $row[3],
                "product_id" => $row[4] === "NULL" ? NULL : $row[4],
                "unit_id" => $row[5] === "NULL" ? NULL : $row[5],
                "description" => $row[6] === "NULL" ? NULL : $row[6],
                "selling_price" => $row[7] === "NULL" ? NULL : $row[7],
                "quantity" => $row[8] === "NULL" ? NULL : $row[8],
                "buying_price" => $row[9] === "NULL" ? NULL : $row[9],
                "total_buying_price" => $row[10] === "NULL" ? NULL : $row[10],
                "total_selling_price" => $row[11] === "NULL" ? NULL : $row[11],
                "barcode_id" => $row[12] === "NULL" ? NULL : $row[12],
                "created_by" => Auth::user()->username,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
