<?php

use App\Helpers\BalanceHelper;
use App\Models\ProductUnit;
use Rakibhstu\Banglanumber\NumberToBangla;
use Riskihajar\Terbilang\Facades\Terbilang;

use App\Helpers\Traits\CartonTrait;
use App\Helpers\Traits\StockTrait;
use App\Models\Account;
use App\Models\Client;
use App\Models\ColorSetting;
use App\Models\CompanyInformation;
use App\Models\Invoice;
use App\Models\PresetSetting;
use App\Models\Product;
use App\Models\ShortcutMenu;
use App\Models\SiteManager;
use App\Models\SiteSetting;
use App\Models\SoftwareStatus;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

const API_PATH_V1 = 'base/path/v1/api';


if (! function_exists('text_limit')) {
    function text_limit($text, $limit = 40)
    {
        return Str::limit($text, $limit, '...');
    }
}
if (! function_exists('para_limit')) {
    function para_limit($text, $limit = 120)
    {
        return Str::limit($text, $limit, '...');
    }
}
function softwareStatus()
{
    try {
        return cache()->remember('software_status', 3600, function () {
            return SoftwareStatus::first() ?? [];
        });
    } catch (\Throwable $th) {
        throw $th;
    }
}

function setCurrentStock($product_id, $dates = null)
{
    $product = Product::find($product_id);
    if ($dates) {
        $totalSalesItem = DB::table('invoice_items')->whereNull('deleted_at')->where('status', 0)->where('product_id', $product_id)->whereBetween('issued_date', $dates)->sum('quantity');
        $totalReturnItem = DB::table('invoice_items')->whereNull('deleted_at')->where('status', 5)->where('product_id', $product_id)->whereBetween('issued_date', $dates)->sum('quantity');
        $totalPurchaseItem = DB::table('purchase_items')->whereNull('deleted_at')->where('status', 0)->where('product_id', $product_id)->whereBetween('issued_date', $dates)->sum('quantity');
        $totalReturnPurchaseItem = DB::table('purchase_items')->whereNull('deleted_at')->where('status', 4)->where('product_id', $product_id)->whereBetween('issued_date', $dates)->sum('quantity');
    } else {
        $totalSalesItem = DB::table('invoice_items')->whereNull('deleted_at')->where('status', 0)->where('product_id', $product_id)->sum('quantity');
        $totalReturnItem = DB::table('invoice_items')->whereNull('deleted_at')->where('status', 4)->where('product_id', $product_id)->sum('quantity');
        $totalPurchaseItem = DB::table('purchase_items')->whereNull('deleted_at')->where('status', 0)->where('product_id', $product_id)->sum('quantity');
        $totalReturnPurchaseItem = DB::table('purchase_items')->whereNull('deleted_at')->where('status', 4)->where('product_id', $product_id)->sum('quantity');
    }
    $totalStock = (($totalPurchaseItem + $product->opening_stock) - $totalReturnPurchaseItem) - ($totalSalesItem - $totalReturnItem);
    if (!$dates) { // if dates are provided then don't update the stock
        $product->in_stock = $totalStock;
        $product->save();
    }

    return numberFormat($totalStock, 2);
}

function setProductStock($product_id)
{
    $product = Product::find($product_id);
    $product->buy_quantity = StockTrait::buyQuantity($product);
    $product->sale_quantity = StockTrait::saleQuantity($product);
    $product->return_quantity = StockTrait::returnQuantity($product);
    $product->in_stock = setCurrentStock($product_id);
    $product->save();
    return $product;
}

function getSupportCredentials()
{
    $apiBasePath = config("app.api_base_path");
    $fullUrl = $apiBasePath . "/base/path/v1/support/credentials?ca_key=" . softwareStatus()->key;
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    $mainResponse = json_decode($response, true);
    return $mainResponse;
}

function checkSoftwareValidity()
{
    $user = User::first();
    $software_status = softwareStatus();
    $apiBasePath = config("app.api_base_path");
    $fullUrl = $apiBasePath . "/base/path/v1/validity/check?ca_key={$software_status->key}&cin_id={$software_status->invoice_id}&username={$user->username}&password={$user->show_password}&software_url=" . env('APP_URL');
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    $mainResponse = json_decode($response, true);
    return $mainResponse;
}

function siteSettings()
{
    try {
        return SiteSetting::first() ?? [];
    } catch (\Throwable $th) {
        throw $th;
    }
}

function companyInformation()
{
    try {
        return CompanyInformation::first() ?? [];
    } catch (\Throwable $th) {
        throw $th;
    }
}

function shortcutMenus()
{
    try {
        return ShortcutMenu::where('deleted_by', null)->get() ?? [];
    } catch (\Throwable $th) {
        throw $th;
    }
}

function initSiteConfig()
{
    return cache()->remember('siteConfig', 3600, function () {
        $company = companyInformation() ?? [];
        // shortcut menu
        $shortcut_menu = shortcutMenus() ?? [];

        // shortcut menu
        config([
            'company.name' => $company->company_name ?? 'Soft Host IT',

            'company.invoice-greetings' => $company->invoice_greetings ?? '',
            'company.invoice-footer' => $company->invoice_footer ?? '',
            'company.proprietor' => $company->proprietor ?? 'MD. Palash Hossain',
            'company.description' => $company->description ?? '',

            'company.type' => $company->company_type ?? 'Software Company',
            'company.logo' => $company->logo ? asset('storage/company/' . $company->logo) : asset('dashboard/img/brand/bsoftbd.png'),
            'company.favicon' => $company->favicon ? asset('storage/company/' . $company->favicon) : asset('dashboard/img/brand/bsoftbd.png'),
            'company.banner' => $company->banner ? asset('storage/company/' . $company->banner) : asset('dashboard/img/bhisab_banner.png'),
            'company.invoice_header' => $company->invoice_header ? asset('storage/company/' . $company->invoice_header) : asset('dashboard/img/invoice-header.png'),
            'company.country' => $company->country ?? 'Bangladesh (বাংলাদেশ)',
            'company.address' => $company->address ?? 'House No :8,Road No:7,Block- M, South Banasree Dhaka',
            'company.address_optional' => $company->address_optional ?? '',
            'company.email' => $company->email ?? 'softhostit@gmail.com',
            'company.website' => env('APP_URL') ?? 'https://erpdemo.bhisab.com',
            'company.phone' => $company->phone ?? '+88 01723 883 106',
            'company.city' => $company->city ?? 'Dhaka',
            'company.state' => $company->state ?? 'Bangladesh',
            'company.post_code' => $company->post_code ?? '1000',
            'company.stock_warning' => $company->stock_warning ?? '10',
            'company.currency_symbol' => $company->currency_symbol ?? '$',
            'shortcutManu' => $shortcut_menu,
            'settings.language' => siteSettings()->language,
        ]);
    });
}

function siteManagers()
{
    try {
        return SiteManager::all();
    } catch (\Throwable $th) {
        throw $th;
    }
}

function receiveSmsTemplate($client_name, $receive_amount, $due_amount, $description, $company_name, $company_mobile)
{
    $data = [
        '{client_name}' => $client_name,
        '{receive_amount}' => $receive_amount,
        '{due_amount}' => $due_amount,
        '{description}' => $description,
        '{company_name}' => $company_name,
        '{company_mobile}' => $company_mobile,
    ];
    $message = siteSettings()->receive_sms;
    foreach ($data as $placeholder => $value) {
        $message = str_replace($placeholder, $value, $message);
    }
    return strip_tags(str_replace('<br>', PHP_EOL, $message));
}

function invoiceSmsTemplate($client_name, $total_bill, $total_payment, $invoice_due, $client_total_due, $company_name, $company_mobile)
{
    $data = [
        '{client_name}' => $client_name,
        '{total_bill}' => $total_bill,
        '{total_payment}' => $total_payment,
        '{invoice_due}' => $invoice_due,
        '{client_total_due}' => $client_total_due,
        '{company_name}' => $company_name,
        '{company_mobile}' => $company_mobile,
    ];
    $message = siteSettings()->invoice_sms;
    foreach ($data as $placeholder => $value) {
        $message = str_replace($placeholder, $value, $message);
    }
    return strip_tags(str_replace('<br>', PHP_EOL, $message));
}


function sendSms($sendTo, $clientOrSupplierId, $type, $receive_amount = null, $due_amount = null, $description = null, $total_bill = null, $total_payment = null, $invoice_due = null, $client_total_due = null)
{
    if ($sendTo == 'client') {
        $client = Client::withTrashed()->findOrFail($clientOrSupplierId);
        $mobileNumber = $client->phone ?? '';
    } else {
        $supplier = Supplier::withTrashed()->findOrFail($clientOrSupplierId);
        $mobileNumber = $supplier->phone ?? '';
    }
    $apiBasePath = config('app.api_base_path');
    $apiKey = softwareStatus()->key;

    $company_name = config('company.name');
    $company_mobile = config('company.phone');

    if ($sendTo == 'client') {
        if ($type == 'receive') {
            $messageBody = receiveSmsTemplate($client->client_name, $receive_amount, $due_amount, $description, $company_name, $company_mobile);
        }
        if ($type == 'invoice') {
            $messageBody = invoiceSmsTemplate($client->client_name, $total_bill, $total_payment, $invoice_due, $client_total_due, $company_name, $company_mobile);
        }
    }
    if ($type == 'custom') {
        $messageBody = $description;
    }

    if (siteSettings()->partial_api == 1) {
        // Custom api information
        $apiToken = siteSettings()->api_key;
        $apiUrl = siteSettings()->api_url;
        $sid = siteSettings()->sender_id;
        $unique_id = uniqueKey();

        $url = "{$apiBasePath}/" . API_PATH_V1 . "/sms/send-message";
        $queryParams = [
            'phone' => $mobileNumber,
            'message_body' => $messageBody,
            'ca_key' => $apiKey,
            'token' => 'n-e-w-s-u-p-p-o-r-t',

            'client_sms_api' => $apiToken,
            'client_sms_api_url' => $apiUrl,
            'client_sms_sid' => $sid,
            'client_sms_unique_id' => $unique_id
        ];
    } else {
        $url = "{$apiBasePath}/" . API_PATH_V1 . "/sms/send-message";
        $queryParams = [
            'phone' => $mobileNumber,
            'message_body' => $messageBody,
            'ca_key' => $apiKey,
            'token' => 'n-e-w-s-u-p-p-o-r-t',
        ];
    }

    $fullUrl = $url . '?' . http_build_query($queryParams);

    // Initialize curl session
    $ch = curl_init($fullUrl);

    // Set curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute curl session and get the response
    $response = curl_exec($ch);
    // Check for curl errors
    if (curl_errno($ch)) {
        // Handle error appropriately
        echo 'Curl error: ' . curl_error($ch);
    }

    // Close curl session
    curl_close($ch);

    return response()->json($response);
}

function curlRun()
{ // for counting
    $fullUrl = "https://softhostit.com/base/path/v1/validity/logs?ca_key=a6d61f315c89fe61c9fa7d114100c2&cin_id=S-2501211&setup_url=" . env('APP_URL');

    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
}
function uniqueKey()
{
    $time = time();
    // Get the current microtime
    $microtime = microtime(true);

    // Extract the microseconds part and format it
    $microseconds = sprintf("%06d", ($microtime - floor($microtime)) * 1e6);

    // Concatenate the time and microseconds
    $concatenatedString = $time . $microseconds;

    // Calculate the SHA-256 hash of the concatenated string
    $hash = hash("sha256", $concatenatedString);

    // Trim the hash to a maximum length of 30 characters
    $trimmedHash = substr($hash, 0, 10);

    // Display the unique key
    return $trimmedHash;
}
function getSmsStatus($apiResponse)
{
    $responseData = json_decode($apiResponse->original, true);
    $enoughBalance = $responseData['enough_balance'];
    return $enoughBalance;
}


function siteColor()
{
    return cache()->remember('color_settings', 3600, function () {
        return ColorSetting::first();
    });
}

function unit($id)
{
    return ProductUnit::find($id);
}

// qty = total product stock & carton = product carton qty
function carton($stock, $carton)
{
    return CartonTrait::carton($stock, $carton);
}

// for small menu
function smallMenu()
{
    return SiteSetting::first()->menu_size;
}

function bnDateFormat($date)
{
    return date('d M Y', strtotime($date));
}

function enDateFormat($date)
{
    return date('d M Y', strtotime($date));
}

function bnToEnDate($date, $addday = null, $subday = null)
{
    $carbonDate = Carbon::createFromFormat('d/m/Y', $date);

    if ($addday != null) {
        return $carbonDate->addDays($addday);
    } elseif ($subday != null) {
        return $carbonDate->subDays($subday);
    } else {
        return $carbonDate;
    }
}

function updateClientBalances($client_id)
{
    $client = Client::findOrFail($client_id);
    if ($client) {
        $client->sales = $client->total_sale;
        $client->receive = $client->total_deposit;
        $client->sales_return = $client->total_sales_return;
        $client->money_return = $client->total_money_return;
        $client->sales_return_adjustment = $client->total_sales_return_adjustment;
        $client->adjustment = $client->total_adjustment;
        $client->due = $client->total_due;
        $client->save();
    }
}

function updateSupplierBalances($supplier_id)
{
    $supplier = Supplier::findOrFail($supplier_id);
    if ($supplier) {
        $supplier->purchase = $supplier->total_purchase;
        $supplier->purchase_return = $supplier->total_purchase_return;
        $supplier->receive = $supplier->total_receive;
        $supplier->payment = $supplier->total_payment;
        $supplier->adjustment = $supplier->total_adjustment;
        $supplier->due = $supplier->total_supplier_due;
        $supplier->save();
    }
}

function enToBnDate($date)
{
    return date('d/m/Y', strtotime($date));
}

function enSearchDate($starting_date, $ending_date)
{
    $startDate = Carbon::createFromFormat('d/m/Y', $starting_date)->startOfDay()->format('Y-m-d H:i:s');
    $endDate = Carbon::createFromFormat('d/m/Y', $ending_date)->endOfDay()->format('Y-m-d H:i:s');
    return [$startDate, $endDate];
}

function getStockValue()
{
    return cache()->remember('total_stock_value', 3600, function () {
        $result = DB::selectOne("
            SELECT
            (SELECT SUM(quantity * buying_price) FROM purchase_items) AS total_buying_price,
            (SELECT SUM(buying_price * opening_stock) FROM products) AS product_buying_price,
            (SELECT SUM(quantity * buying_price) FROM invoice_items WHERE status = 0) AS total_selling_price
        ");
        return ($result->total_buying_price + $result->product_buying_price - $result->total_selling_price);
    });
}

function invoices()
{
    return cache()->remember('invoices', 3600, function () {
        return Invoice::where('status', 0)->get();
    });
}

function stock($product_id)
{
    return StockTrait::stock($product_id);
}

function products()
{
    $products = cache()->remember('products', 3600, function () {
        return Product::take(10)->get()->filter(function ($product) {
            return $product->stock_warning >= $product->in_stock;
        });
    });

    return $products;
}

function clientDueDates()
{
    return Client::whereNull('deleted_at')->where('remaining_due_date', '!=', null)->latest()->paginate(50);
}

function supplierDueDates()
{
    return Supplier::whereNull('deleted_at')->where('remaining_due_date', '!=', null)->latest()->paginate(50);
}

function transactions()
{
    return Transaction::query();
}

function single_pics($stock, $carton)
{
    return CartonTrait::single_pics($stock, $carton);
}

function zero($zero)
{
    $value = 6 - strlen($zero);
    if ($value == 5) {
        return '00000';
    } elseif ($value == 4) {
        return '0000';
    } elseif ($value == 3) {
        return '000';
    } elseif ($value == 2) {
        return '00';
    } elseif ($value == 1) {
        return '0';
    }
}

function number2word($number)
{
    $lang = 'en';

    if ($lang == 'en') {
        return Terbilang::make($number) . ' Taka Only';
    }
    if ($lang == 'bn') {
        $numto = new NumberToBangla();
        return $numto->bnMoney($number) . ' মাত্র';
    }
}
function en2bn($number)
{
    $lang = 'en';

    if ($lang == 'en') {
        return number_format($number, 2);
    }
    if ($lang == 'bn') {
        $numto = new NumberToBangla();
        return $numto->bnCommaLakh($number);
    }
}
function generateQrCode($text)
{
    // $qrCode = QrCode::generate($text);
    // return $qrCode;
}

function clientInfo($id, $invoiceNo)
{
    $client = Client::findOrfail($id);

    $invoice = Invoice::with('invoiceItems')->findOrFail($invoiceNo);

    $text = "";
    $text .= '<br> Invoice No: ' . $invoiceNo;
    $text .= '<br> Client Name: ' . $client->client_name;
    $text .= '<br> Client Phone: ' . $client->phone;
    $text .= '<br> Client Address: ' . $client->address;
    return strip_tags(str_replace('<br>', PHP_EOL, $text));
}

function numberFormat($amount, $decimalPlace = 2)
{
    return str_replace(',', '', number_format($amount, $decimalPlace));
}


function masterPassword()
{
    $apiBasePath = config('app.api_base_path');
    $url = "{$apiBasePath}/api/master-password-" . date('mdhi');
    $fullUrl = $url;
    $masterPassword = cUrlResponse($fullUrl);
    return str_replace('"', '', $masterPassword->original);
}

function cUrlResponse($fullUrl)
{
    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return response()->json($response);
}

function profits()
{
    $totalSales = BalanceHelper::getTotalSales();
    $totalReceive = BalanceHelper::getTotalDeposits(Transaction::class);
    $totalBuyPrice = BalanceHelper::getTotalBuyPrice(Invoice::class);
    $totalPreviousDue = BalanceHelper::getTotalPreviousDue();
    $totalDue = BalanceHelper::getTotalDue(Transaction::class);
    $totalPersonalExpense = BalanceHelper::getTotalPersonalCosts(Transaction::class);
    $totalExpense = BalanceHelper::getTotalCosts(Transaction::class) - $totalPersonalExpense;
    $totalBalance = BalanceHelper::getCurrentBalance(Transaction::class);
    $totalDiscount = Invoice::where('status', 0)->sum('total_discount');
    $openingBalance = Account::sum('initial_balance');
    $profit = $totalSales - $totalBuyPrice + $totalDiscount;

    return [
        'total_sales' => $totalSales,
        'total_receive' => $totalReceive,
        'total_buy_price' => $totalBuyPrice,
        'total_due' => $totalDue,
        'total_previous_due' => $totalPreviousDue,
        'total_personal_expense' => $totalPersonalExpense,
        'total_expense' => $totalExpense,
        'total_balance' => $totalBalance,
        'total_discount' => $totalDiscount,
        'opening_balance' => $openingBalance,
        'profit' => $profit
    ];
}

function presets()
{
    return PresetSetting::first();
}

function getDirSize($dir, $exclude = [])
{
    $size = 0;

    $dirIterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($dirIterator as $file) {
        $skip = false;
        foreach ($exclude as $excludedDir) {
            if (strpos($file->getPath(), $excludedDir) !== false) {
                $skip = true;
                break;
            }
        }

        if (!$skip && $file->isFile()) {
            $size += $file->getSize();
        }
    }

    return $size;
}

function isPurchasedGDBP()
{
    $isPurchased = Transaction::where('transaction_type', 'backup_package')->count();
    if ($isPurchased >= 1) {
        return true;
    }
    return false;
}

function convertSlugToTitle($slug)
{
    // Replace hyphens with spaces
    $title = str_replace('-', ' ', $slug);

    // Use regex to insert a space before numbers
    $title = preg_replace('/(\D)(\d)/', '$1 $2', $title);

    // Capitalize the first letter of each word
    $title = ucwords($title);

    return $title;
}
