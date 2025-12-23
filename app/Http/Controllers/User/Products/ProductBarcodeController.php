<?php

namespace App\Http\Controllers\User\Products;

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
        $pageTitle = __('messages.product').' '.__('messages.barcode');
        return view('user.products.product.barcode', compact('pageTitle'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
