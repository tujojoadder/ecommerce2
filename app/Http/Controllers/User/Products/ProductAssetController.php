<?php

namespace App\Http\Controllers\User\Products;

use App\DataTables\ProductAssetDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\FileManager;
use App\Http\Requests\ProductAssetRequest;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductAssetController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductAssetDataTable $dataTable)
    {
        $query_string = $_SERVER['QUERY_STRING'];
        if ($query_string == 'size') {
            $pageTitle = __('messages.product') . ' ' . __('messages.size');
        } else if ($query_string == 'brand') {
            $pageTitle = __('messages.product') . ' ' . __('messages.brand');
        } else {
            $pageTitle = __('messages.product') . ' ' . __('messages.color');
        }
        return $dataTable->render('user.products.product.asset.index', compact('pageTitle'));
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
    public function store(ProductAssetRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ProductAsset();
            $data->asset = $request->asset;
            $data->type = $request->type;
            $data->created_by = Auth::user()->username;
            $data->save();
            DB::commit();

            toast('Product Brand Added Successfully!', 'success');
            return response()->json($data);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProductAsset::findOrFail($id);
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAssetRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = ProductAsset::findOrFail($id);
            $data->asset = $request->asset;
            $data->save();

            DB::commit();
            toast('Product Updated Successfully!', 'success');
            return response()->json($data);
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
        $this->deleteLog(ProductAsset::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
