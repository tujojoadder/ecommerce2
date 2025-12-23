<?php

namespace App\Http\Controllers\Api\User\Products;

use App\DataTables\ProductDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductBarcodeRequest;
use Illuminate\Http\Request;
use App\Models\ProductBarcode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class ProductBarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.barcode');
        return view('user.products.product.barcode', compact('pageTitle'));
    }
}
