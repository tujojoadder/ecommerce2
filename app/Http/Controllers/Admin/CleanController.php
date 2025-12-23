<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\DeleteLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ExpenseCategory;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\ReceiveCategory;
use App\Models\Salary;
use App\Models\Supplier;
use App\Models\SupplierGroup;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CleanController extends Controller
{
    public function clean()
    {
        try {
            DeleteLog::truncate();
            Client::truncate();
            ClientGroup::truncate();
            Supplier::truncate();
            SupplierGroup::truncate();
            ExpenseCategory::truncate();
            ReceiveCategory::truncate();
            Invoice::truncate();
            InvoiceItem::truncate();
            Purchase::truncate();
            PurchaseItem::truncate();
            Department::truncate();
            Designation::truncate();
            Salary::truncate();
            Attendance::truncate();
            Warehouse::truncate();
            Transaction::truncate();
            Account::truncate();
            Product::truncate();
            ProductGroup::truncate();
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
