<?php

use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\CRM\Client\ClientController;
use App\Http\Controllers\Api\User\CRM\Client\ClientGroupController;
use App\Http\Controllers\Api\User\CRM\Supplier\SupplierController;
use App\Http\Controllers\Api\User\CRM\Supplier\SupplierGroupController;
use App\Http\Controllers\Api\User\Products\ProductAssetController;
use App\Http\Controllers\Api\User\Products\ProductBarcodeController;
use App\Http\Controllers\Api\User\Products\ProductController;
use App\Http\Controllers\Api\User\Products\ProductGroupController;
use App\Http\Controllers\Api\User\Products\ProductUnitController;
use App\Http\Controllers\PaymentController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Picqer\Barcode\BarcodeGeneratorPNG;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/insert-user', [RegisterController::class, 'insertUserData']);
Route::post('/register', [RegisterController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/check-user', [RegisterController::class, 'checkUser']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::prefix('product')->as('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('userwise/{id}', [ProductController::class, 'getByUser']);
    Route::post('store', [ProductController::class, 'store']);
    Route::get('view/{id}', [ProductController::class, 'show']);
    Route::get('edit/{id}', [ProductController::class, 'edit']);
    Route::put('update/{id}', [ProductController::class, 'update']);
    Route::get('delete/{id}', [ProductController::class, 'destroy']);

    //product group
    Route::prefix('group')->as('group.')->group(function () {
        Route::get('/', [ProductGroupController::class, 'index']);
        Route::get('userwise-group/{id}', [ProductGroupController::class, 'getGroupByUser']);
        Route::get('create', [ProductGroupController::class, 'create']);
        Route::post('store', [ProductGroupController::class, 'store']);
        Route::get('view/{id}', [ProductGroupController::class, 'show']);
        Route::put('update/{id}', [ProductGroupController::class, 'update']);
        Route::get('delete/{id}', [ProductGroupController::class, 'destroy']);
    });
    //product Unit
    Route::prefix('unit')->as('unit.')->group(function () {
        Route::get('/', [ProductUnitController::class, 'index']);
        Route::get('userwise-unit/{id}', [ProductUnitController::class, 'getUnitByUser']);
        Route::get('create', [ProductUnitController::class, 'create']);
        Route::post('store', [ProductUnitController::class, 'store']);
        Route::get('view/{id}', [ProductUnitController::class, 'show']);
        Route::get('edit/{id}', [ProductUnitController::class, 'edit']);
        Route::put('update/{id}', [ProductUnitController::class, 'update']);
        Route::get('delete/{id}', [ProductUnitController::class, 'destroy']);
    });
    //product asset
    Route::prefix('asset')->as('asset.')->group(function () {
        Route::get('/', [ProductAssetController::class, 'index']);
        Route::get('create', [ProductAssetController::class, 'create']);
        Route::post('store', [ProductAssetController::class, 'store']);
        Route::get('view/{id}', [ProductAssetController::class, 'show']);
        Route::get('edit/{id}', [ProductAssetController::class, 'edit']);
        Route::put('update/{id}', [ProductAssetController::class, 'update']);
        Route::get('delete/{id}', [ProductAssetController::class, 'destroy']);
    });

    //product Barcode
    Route::prefix('barcode')->as('barcode.')->group(function () {
        Route::get('/', [ProductBarcodeController::class, 'index']);
    });
});

Route::prefix('client')->as('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('userwise-client/{id}', [ClientController::class, 'getClientByUser']);
    Route::post('store', [ClientController::class, 'store']);
    Route::get('view/{id}', [ClientController::class, 'show']);
    Route::get('statements', [ClientController::class, 'statements']);
    Route::put('update/{id}', [ClientController::class, 'update']);
    Route::get('delete/{id}', [ClientController::class, 'destroy']);

    Route::put('update-image/{id}', [ClientController::class, 'updateImage']);

    Route::prefix('group')->as('group.')->group(function () {
        Route::get('/', [ClientGroupController::class, 'index']);
        Route::get('userwise-group/{id}', [ClientGroupController::class, 'getGroupByUser']);
        Route::post('store', [ClientGroupController::class, 'store']);
        Route::get('view/{id}', [ClientGroupController::class, 'show']);
        Route::get('edit/{id}', [ClientGroupController::class, 'edit']);
        Route::put('update/{id}', [ClientGroupController::class, 'update']);
        Route::get('delete/{id}', [ClientGroupController::class, 'destroy']);
    });
});

// Supplier routes
Route::prefix('supplier')->as('supplier.')->group(function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('userwise-supplier/{id}', [SupplierController::class, 'getSupplierByUser']);
    Route::get('/statements', [SupplierController::class, 'statements']);
    Route::post('store', [SupplierController::class, 'store']);
    Route::get('view/{id}', [SupplierController::class, 'show']);
    Route::put('update/{id}', [SupplierController::class, 'update']);
    Route::get('delete/{id}', [SupplierController::class, 'destroy']);

    Route::put('update-image/{id}', [SupplierController::class, 'updateImage']);

    Route::prefix('group')->as('group.')->group(function () {
        Route::get('/', [SupplierGroupController::class, 'index']);
        Route::get('userwise-group/{id}', [SupplierGroupController::class, 'getGroupByUser']);
        Route::get('create', [SupplierGroupController::class, 'create']);
        Route::post('store', [SupplierGroupController::class, 'store']);
        Route::get('view/{id}', [SupplierGroupController::class, 'show']);
        Route::get('edit/{id}', [SupplierGroupController::class, 'edit']);
        Route::put('update/{id}', [SupplierGroupController::class, 'update']);
        Route::get('delete/{id}', [SupplierGroupController::class, 'destroy']);
    });
});

Route::get('/buy/gdrive/backup', [PaymentController::class, 'buyGdrivePackage'])->name("payment.gdp");

Route::get('/get-product-barcode/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $barcodeGenerator = new BarcodeGeneratorPNG();
    $barcode = $product->custom_barcode_no ?? $product->id;
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'selling_price' => $product->selling_price,
        'barcode' => base64_encode($barcodeGenerator->getBarcode($barcode, BarcodeGeneratorPNG::TYPE_CODE_128)),
        'barcode_number' => $barcode,
    ]);
});
