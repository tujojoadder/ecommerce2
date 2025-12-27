<?php

use App\Http\Controllers\Frontend\BlogCategoryController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use App\Models\FieldManager;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::as('frontend.')->group(function () {
    /*        Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('about.us');
    Route::get('product/{slug}/{id}', [FrontendController::class, 'productView'])->name('product.view');
    Route::get('/get/categories', [FrontendController::class, 'getCategories'])->name('get.categories'); */
    // Cart ============
    Route::prefix('add-cart')->as('addCart.')->group(function () {
        Route::post('/store', [CartController::class, 'store'])->name('store');
        Route::post('/storecheckout', [CartController::class, 'storeCheckOut'])->name('store.checkout');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::get('/get/data', [CartController::class, 'fetchData'])->name('get.data');
        Route::get('/cookie/remove/{product_id}', [CartController::class, 'destroy'])->name('destroy');
    });
    /* turjo */
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.item');
    //blog
    Route::prefix('blog')->as('blog.')->group(function () {

        //blog category
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
            Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
            Route::post('/store', [BlogCategoryController::class, 'store'])->name('store');

            Route::get('/{blogCategory}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
            Route::put('/{blogCategory}', [BlogCategoryController::class, 'update'])->name('update');
            Route::delete('/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('destroy');
            Route::post('/{blogCategory}/status', [BlogCategoryController::class, 'updateStatus'])->name('status');
        });
    });


    //checkout
    Route::prefix('checkout')->as('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('store');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    });
});

Route::get('/get/district/{division_id}', [HomeController::class, 'getdistrict'])->name('get.district');
Route::get('/get/upazila/{district_id}', [HomeController::class, 'getUpazila'])->name('get.upazila');




// Route::get('/', function () {
//     if (env('DB_DATABASE') == null) {
//         return redirect()->route('install.index');
//     } else {
//         request()->getRequestUri();
//         if (request()->getRequestUri() == '/public/index.php' || request()->getRequestUri() == '/index.php') {
//             return redirect(env('APP_URL'));
//         }
//         return redirect()->route('user.home');
//     }
// });


Route::get('/payment', [PaymentController::class, 'index'])->name("payment");
Route::post('/payment', [PaymentController::class, 'manage'])->name("payment.manage");
Route::get('/recharge/sms/balance', [PaymentController::class, 'rechargeSmsBalance'])->name("recharge.sms.balance");
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invoice/{id}', [GuestController::class, 'invoice'])->name('invoice.view');

Route::get('sales-bulk', function () {
    return response()->download(public_path('bulk-files/sales-bulk.zip'));
})->name('download.sales.bulk');
Route::get('purchase-bulk', function () {
    return response()->download(public_path('bulk-files/purchase-bulk.zip'));
})->name('download.purchase.bulk');
Route::get('product-bulk', function () {
    return response()->download(public_path('bulk-files/products.xlsx'));
})->name('download.product.bulk');
Route::get('clients-bulk', function () {
    return response()->download(public_path('bulk-files/clients.xlsx'));
})->name('download.clients.bulk');
Route::get('suppliers-bulk', function () {
    return response()->download(public_path('bulk-files/suppliers.xlsx'));
})->name('download.suppliers.bulk');

Route::get('lang', [LanguageController::class, 'index']);
Route::get('lang/change', [LanguageController::class, 'change'])->name('change.lang');

Route::get('optimize:clear', function () {
    Artisan::call('optimize:clear');
    toastr()->info('Cache cleared successfully!');
    return redirect()->back();
})->name('optimize.clear');

// Route::get('migrate', function () {
//     Artisan::call('migrate:refresh --path=database/migrations/2023_08_22_122908_create_shortcut_menus_table.php');
// });

// Route::get('add-field-manager', function () {
//     FieldManager::insert([
//         [
//             'table_name' => 'invoices',
//             'field_name' => 'print_destination',
//             'status' => 1, // 1 = Invoice View, 0 = POS View
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//     ]);
// });
Route::get('migrate-refresh', function () {
    // Artisan::call('migrate:refresh --path=database/migrations/2023_08_08_083536_create_suppliers_table.php');
});

// Route::get('/test-product-create', function(){
//     $pageTitle = 'Test';
//     return view('test', compact('pageTitle'));
// });