<?php

namespace App\Http\Controllers;

use App\DataTables\StockWarningProductsDataTable;
use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\StockTrait;
use App\Models\Account;
use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductAsset;
use App\Models\ProductGroup;
use App\Models\ProductUnit;
use App\Models\Project;
use App\Models\ReceiveCategory;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use App\Models\Supplier;
use App\Models\Bank;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountGroup;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SupplierGroup;
use App\Models\CompanyInformation;
use App\Models\FieldManager;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\ReceiveSubcategory;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\PresetSetting;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    use StockTrait, BalanceTrait; // Stock Trait and Balance Trait
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateClientWallet($id)
    {
        try {
            updateClientBalances($id);
            return response()->json(['success' => 'Client Wallet Updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function updateSupplierWallet($id)
    {
        try {
            updateSupplierBalances($id);
            return response()->json(['success' => 'Supplier Wallet Updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function updateTotalBalance()
    {
        cache()->forget('wallets');
        $wallets = cache()->remember('wallets', 3600, function () {
            return [$this->allWallets()];
        });
        try {
            $wallet = $wallets['0'];
            $siteSetting = SiteSetting::first();
            $siteSetting->today_sales = str_replace(',', '', $wallet['today_sales']);
            $siteSetting->today_deposit = str_replace(',', '', $wallet['today_deposit']);
            $siteSetting->today_cost = str_replace(',', '', $wallet['today_cost']);
            $siteSetting->today_due = str_replace(',', '', $wallet['today_due']);
            $siteSetting->today_balance = str_replace(',', '', $wallet['today_balance']);

            $siteSetting->monthly_sales = str_replace(',', '', $wallet['monthly_sales']);
            $siteSetting->monthly_deposit = str_replace(',', '', $wallet['monthly_deposit']);
            $siteSetting->monthly_cost = str_replace(',', '', $wallet['monthly_cost']);
            $siteSetting->monthly_due = str_replace(',', '', $wallet['monthly_due']);
            $siteSetting->monthly_balance = str_replace(',', '', $wallet['monthly_balance']);

            $siteSetting->total_purchase = str_replace(',', '', $wallet['total_purchase']);
            $siteSetting->total_sales = str_replace(',', '', $wallet['total_sales']);
            $siteSetting->total_deposit = str_replace(',', '', $wallet['total_deposit']);
            $siteSetting->total_cost = str_replace(',', '', $wallet['total_cost']);
            $siteSetting->total_return = str_replace(',', '', $wallet['total_return']);
            $siteSetting->total_due = str_replace(',', '', $wallet['total_due']);
            $siteSetting->total_client_due = str_replace(',', '', $wallet['total_client_due']);
            $siteSetting->total_client_advance = str_replace(',', '', $wallet['total_client_advance']);
            $siteSetting->total_previous_due = str_replace(',', '', $wallet['total_previous_due']);
            $siteSetting->total_stock_value = str_replace(',', '', $wallet['total_stock_value']);
            $siteSetting->total_balance = str_replace(',', '', $wallet['balance']);
            $siteSetting->save();
            toastr()->success('Total Balance Updated');
            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function get_clients()
    {
        $query = request()->input('search_text');

        $referer = request()->header()['referer'][0];
        $baseUrl = request()->getSchemeAndHttpHost();
        $desiredPart = strtok(str_replace($baseUrl, "", $referer), '?');
        if ($query) {
            if ($desiredPart == '/user/loan') {
                $data = Client::where('status', 1)
                    ->where('type', 1)
                    ->where('client_name', 'like', '%' . $query . '%')
                    ->orWhere('phone', 'like', '%' . $query . '%')
                    ->orWhere('company_name', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%')
                    ->whereNull('deleted_at')->get()->take(20);
            } else {
                $data = Client::where('status', 1)
                    ->where('type', 0)
                    ->where('client_name', 'like', '%' . $query . '%')
                    ->orWhere('phone', 'like', '%' . $query . '%')
                    ->orWhere('company_name', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%')
                    ->whereNull('deleted_at')->get()->take(20);
            }
        } else {
            if ($desiredPart == '/user/loan') {
                $data = Client::where('type', 1)->where('status', 1)->whereNull('deleted_at')->latest()->get()->take(10);
            } else {
                $data = Client::where('type', 0)->where('status', 1)->whereNull('deleted_at')->latest()->get()->take(10);
            }
        }
        return response()->json($data);
    }
    public function get_clients_group()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ClientGroup::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ClientGroup::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }

    public function get_category()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Category::where('name', 'like', '%' . $query . '%')->where('is_deleted', 0)->get()->take(20);
        } else {
            $data = Category::where('is_deleted', 0)->get();
        }
        return response()->json($data);
    }

    public function get_sub_category($category_id)
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = SubCategory::where('name', 'like', '%' . $query . '%')
                ->where('category_id', $category_id)
                ->where('is_deleted', 0)
                ->get()
                ->take(20);
        } else {
            $data = SubCategory::where('is_deleted', 0)
                ->where('category_id', $category_id)
                ->get()
                ->take(20);
        }
        return response()->json($data);
    }

    public function get_sub_sub_category($category_id, $subcategory_id)
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = SubSubCategory::where('name', 'like', '%' . $query . '%')
                ->where('category_id', $category_id)
                ->where('subcategory_id', $subcategory_id)
                ->where('is_deleted', 0)
                ->get()
                ->take(20);
        } else {
            $data = SubSubCategory::where('is_deleted', 0)
                ->where('category_id', $category_id)
                ->where('subcategory_id', $subcategory_id)
                ->get()
                ->take(20);
        }
        return response()->json($data);
    }

    public function getBranches()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Branch::where('name', 'like', '%' . $query . '%')->orWhere('address', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Branch::whereNull('deleted_at')->get()->take(30);
        }
        return response()->json($data);
    }
    public function getBranch($id)
    {
        $data = Branch::findOrFail($id);
        return response()->json($data);
    }

    public function get_suppliers()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Supplier::where('supplier_name', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere('phone_optional', 'like', '%' . $query . '%')
                ->orWhere('company_name', 'like', '%' . $query . '%')
                ->orWhere('address', 'like', '%' . $query . '%')
                ->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Supplier::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_suppliers_group()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = SupplierGroup::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = SupplierGroup::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_accounts()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Account::where('title', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Account::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_account($id)
    {
        $data = Account::findOrFail($id);
        $data['current_balance'] = $data->balance($id);
        return response()->json($data);
    }
    public function get_payment_methods()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = PaymentMethod::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = PaymentMethod::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_projects()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Project::where('project_name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Project::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_invoices()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Invoice::where('id', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Invoice::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_products()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Product::where('name', 'like', '%' . $query . '%')
                ->orWhere('buying_price', 'like', '%' . $query . '%')
                ->orWhere('selling_price', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->whereNull('deleted_at')->latest()->get()->take(20);
        } else {
            $data = Product::whereNull('deleted_at')->take(20)->latest()->get()->take(20);
        }
        return response()->json($data);
    }

    public function get_product($id)
    {
        if (config('products_custom_barcode_no') == 1 && request()->has('barcode')) {
            $data = Product::with(['unit', 'prices:id,product_id,selling_price,buying_price,purchase_id'])->where('custom_barcode_no', $id)->first();
            if ($data === null || $data->custom_barcode_no === null) {
                $data = Product::with(['unit', 'prices:id,product_id,selling_price,buying_price,purchase_id'])->findOrFail($id);
                if (config('products_new_price_sale_only') == 1) {
                    $data->multi_price_latest = $data->prices->last() ?? $data->buying_price;
                    $data->selling_price = $data->prices->last()->selling_price ?? $data->selling_price;
                } else {
                    $prices = $data->prices;
                    $prices[] = ['product_id' => $data->id, 'buying_price' => $data->buying_price, 'purchase_id' => '0', 'item_wise_stock' => $data->stockCount($data->id), 'unit' => null, 'unit_name' => $data->unit_name];
                    $data->multi_price = $prices;
                }
            } else {
                $data = Product::with(['unit', 'prices:id,product_id,selling_price,buying_price,purchase_id'])->where('custom_barcode_no', $id)->first();
                if (config('products_new_price_sale_only') == 1) {
                    $data->multi_price_latest = $data->prices->last() ?? $data->buying_price;
                    $data->selling_price = $data->prices->last()->selling_price ?? $data->selling_price;
                } else {
                    $prices = $data->prices;
                    $prices[] = ['product_id' => $data->id, 'buying_price' => $data->buying_price, 'purchase_id' => '0', 'item_wise_stock' => $data->stockCount($data->id), 'unit' => null, 'unit_name' => $data->unit_name];
                    $data->multi_price = $prices;
                }
            }
        } else {
            $data = Product::with(['unit', 'prices:id,product_id,selling_price,buying_price,purchase_id'])->findOrFail($id);
            if (config('products_new_price_sale_only') == 1) {
                $data->multi_price_latest = $data->prices->last() ?? ['buying_price' => $data->buying_price];
                $data->selling_price = $data->prices->last()->selling_price ?? $data->selling_price;
            } else {
                $prices = $data->prices;
                $prices[] = ['product_id' => $data->id, 'buying_price' => $data->buying_price, 'purchase_id' => '0', 'item_wise_stock' => $data->stockCount($data->id), 'unit' => null, 'unit_name' => $data->unit_name];
                $data->multi_price = $prices;
            }
        }
        $data['total_stock'] = $this->stock($data->id);
        $data['opening_stock'] = $this->stockOpening($data->id);
        $data['unit_name'] = $data->unit_name;
        $data['group_name'] = $data->group_name;
        $data['brand_name'] = $data->brand_name;
        $data['size_name'] = $data->size_name;
        $data['color_name'] = $data->color_name;
        $data['asset_name'] = $data->asset_name;
        return response()->json($data);
    }

    public function get_product2($id) {}

    public function get_purchased_products()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = PurchaseItem::with('product')
                ->whereNull('deleted_at')
                ->get()
                ->unique('selling_price');
        } else {
            $data = PurchaseItem::with('product')
                ->whereNull('deleted_at')
                ->get()
                ->unique('selling_price')
                ->take(10);
        }
        return response()->json($data);
    }
    public function get_stock_warning_products(StockWarningProductsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
    public function get_purchased_product($id)
    {
        $data = PurchaseItem::with(['product', 'unit'])->findOrFail($id);
        $data['total_stock'] = $this->stock($data->product_id);
        $data['seperate_stock'] = $this->stockIndividual($data->purchase_id, $data->product_id);
        return response()->json($data);
    }
    public function get_product_groups()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ProductGroup::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ProductGroup::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_product_color($id)
    {
        $data = ProductAsset::findOrFail($id);
        return response()->json($data);
    }
    public function get_product_size($id)
    {
        $data = ProductAsset::findOrFail($id);
        return response()->json($data);
    }
    public function get_product_brand($id)
    {
        $data = Brand::findOrFail($id);
        return response()->json($data);
    }
    public function get_product_group($id)
    {
        $data = ProductGroup::findOrFail($id);
        return response()->json($data);
    }
    public function get_product_units()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ProductUnit::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ProductUnit::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_product_unit($id)
    {
        $data = ProductUnit::findOrFail($id);
        return response()->json($data);
    }
    public function get_product_colors()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ProductAsset::where('type', 'color')->where('asset', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ProductAsset::where('type', 'color')->whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_product_sizes()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ProductAsset::where('type', 'size')->where('asset', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ProductAsset::where('type', 'size')->whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_product_brands()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Brand::where('brand_name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Brand::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_warehouses()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Warehouse::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Warehouse::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function receive_category()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ReceiveCategory::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ReceiveCategory::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function receive_subcategory()
    {
        $qs = $_SERVER['QUERY_STRING'];
        $query = request()->input('search_text');
        if ($query) {
            $data = ReceiveSubcategory::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else if ($qs !== null) {
            $data = ReceiveSubcategory::where('category_id', $qs)->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ReceiveSubcategory::whereNull('deleted_at')->get()->take(10);
        }
        return response()->json($data);
    }
    public function expense_category()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ExpenseCategory::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ExpenseCategory::whereNull('deleted_at')->get()->take(10);
        }
        return response()->json($data);
    }
    public function expense_subcategory()
    {
        $qs = $_SERVER['QUERY_STRING'];
        $query = request()->input('search_text');
        if ($query) {
            $data = ExpenseSubcategory::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else if ($qs !== null) {
            $data = ExpenseSubcategory::where('category_id', $qs)->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ExpenseSubcategory::whereNull('deleted_at')->get()->take(10);
        }
        return response()->json($data);
    }
    public function companyInformation()
    {
        $data = CompanyInformation::whereNull('deleted_at')->first();
        return response()->json($data);
    }
    public function get_banks()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Bank::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Bank::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_chart_of_acounts()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ChartOfAccount::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ChartOfAccount::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function get_chart_of_acount_groups()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = ChartOfAccountGroup::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = ChartOfAccountGroup::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function getAllWallets()
    {
        $data['wallet_amounts'] = $this->allWallets();
        $data['wallet_links'] = $this->getWalletLinks();
        return response()->json($data);
    }
    public function get_staffs()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = User::whereNot('username', 'admin')->where('name', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('username', 'like', '%' . $query . '%')
                ->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = User::whereNot('username', 'admin')->whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }

    public function getStaffDue($id)
    {
        $data = User::findOrFail($id);
        $balance = [];
        $balance['total_due'] = $data->totalDue($id);
        $balance['total_payment'] = $data->totalPayment($id);
        $balance['total_monthly_payment'] = $data->totalMonthlyPayment($id, date('m'), date('Y'));
        $balance['total_monthly_due'] = $data->totalMonthlyDue($id, date('m'), date('Y'));
        return $balance;
    }
    public function getStaffDepartment()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Department::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Department::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function getStaffDesignation()
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Designation::where('name', 'like', '%' . $query . '%')->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Designation::whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }

    public function enableOrDisableField($table, $field)
    {
        $fieldManager = FieldManager::where('table_name', $table)->where('field_name', $field)->first();

        $data = FieldManager::findOrFail($fieldManager->id);
        if ($data->status == 0) {
            $data->status = 1;
        } else {
            $data->status = 0;
        }
        $data->save();
        return response()->json($data);
    }

    public function updateSalePricePercentage()
    {
        $percentage = request()->percentage;
        $setting = SiteSetting::first();
        $setting->sale_price_percentage = $percentage;
        $setting->save();
        return response()->json($setting);
    }

    public function updateLabourCostRate()
    {
        $labour_cost_rate = request()->labour_cost_rate;
        $setting = SiteSetting::first();
        $setting->labour_cost_rate = $labour_cost_rate;
        $setting->save();
        return response()->json($setting);
    }

    public function updateGoogleDriveFolderId()
    {
        $setting = SiteSetting::first();
        $setting->google_drive_folder_id = request()->google_drive_folder_id;
        $setting->save();
        return response()->json($setting);
    }

    public function getSupplierDue($id)
    {
        $data = $this->supplierWallets($id)['supplier_total_due'];
        // $totalPurchase = Purchase::where('supplier_id', $id)->whereNull('deleted_at')->sum('grand_total');
        // $totalPaid = Transaction::where('supplier_id', $id)->whereNull('deleted_at')->sum('amount');
        // $data = $totalPurchase - $totalPaid;
        return $data;
    }

    public function getSupplierInfo($id)
    {
        $data = Supplier::findOrFail($id);
        return $data;
    }
    public function getSupplierInvoices($id)
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Purchase::where('supplier_id', $id)
                ->where('invoice_no', 'like', '%' . $query . '%')
                ->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Purchase::where('supplier_id', $id)->whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function getSupplierInvoicesDue($purchase_id)
    {
        $totalPurchase = Purchase::where('id', $purchase_id)->whereNull('deleted_at')->sum('grand_total');
        $totalPaid = Transaction::where('type', 'cost')->where('transaction_type', 'purchase')->where('invoice_id', $purchase_id)->whereNull('deleted_at')->sum('amount');
        $data = $totalPurchase - $totalPaid;
        return response()->json($data);
    }

    public function getClientDue($id)
    {
        $data = $this->clientWallets($id)['client_total_due'];
        return $data;
    }

    public function getClientInfo($id)
    {
        $data = Client::findOrFail($id);
        $data['remaining_due_date'] = $data->remaining_due_date ? enToBnDate($data->remaining_due_date) : '';
        return response()->json($data);
    }

    public function getClientGroup($id)
    {
        $data = ClientGroup::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getCategoryInfo($id)
    {
        $data = Category::findOrFail($id) ?? null;
        return response()->json($data);
    }

    public function getSubCategoryInfo($id)
    {
        $data = SubCategory::findOrFail($id) ?? null;
        return response()->json($data);
    }

    public function getSubSubCategoryInfo($id)
    {
        $data = SubSubCategory::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getSupplierGroup($id)
    {
        $data = SupplierGroup::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getExpenseCategory($id)
    {
        $data = ExpenseCategory::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getExpenseSubCategory($id)
    {
        $data = ExpenseSubCategory::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getPaymentMethod($id)
    {
        $data = PaymentMethod::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getReceiveCategory($id)
    {
        $data = ReceiveCategory::findOrFail($id) ?? null;
        return response()->json($data);
    }
    public function getAccount($id)
    {
        $data = Account::findOrFail($id) ?? null;
        return response()->json($data);
    }

    public function getClientInvoices($id)
    {
        $query = request()->input('search_text');
        if ($query) {
            $data = Invoice::where('client_id', $id)->whereNotIn('status', [4, 5])->whereNull('deleted_at')->get()->take(20);
        } else {
            $data = Invoice::where('client_id', $id)->whereNotIn('status', [4, 5])->whereNull('deleted_at')->get()->take(20);
        }
        return response()->json($data);
    }
    public function getClientInvoiceDue($invoice_id)
    {
        $data = $this->invoiceDue($invoice_id);
        return response()->json($data);
    }

    public function setSitePreset($type, $value)
    {
        $preset = PresetSetting::first();
        $preset->$type = $value;
        $preset->save();
        return response()->json($preset);
    }
}