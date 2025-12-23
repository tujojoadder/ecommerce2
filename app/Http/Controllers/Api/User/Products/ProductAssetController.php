<?php

namespace App\Http\Controllers\Api\User\Products;

use App\DataTables\ProductAssetDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\FileManager;
use App\Http\Requests\ProductAssetRequest;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductAssetController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = ProductAsset::where('deleted_at', null)->latest();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = new ProductAsset();
            $data->asset = $request->asset;
            $data->type = $request->type;
            $data->created_by = $request->created_by;
            $data->save();
            return response()->json(['message' => 'Asset Added Successfully!', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = ProductAsset::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
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
        $data = ProductAsset::findOrFail($id);
        $data->asset = $request->asset;
        $data->save();

        toast('Product Updated Successfully!', 'success');
        return response()->json($data);
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
