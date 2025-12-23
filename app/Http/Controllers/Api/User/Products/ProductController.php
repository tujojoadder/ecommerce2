<?php

namespace App\Http\Controllers\Api\User\Products;

use App\DataTables\ProductDataTable;
use App\DataTables\ProductGroupDataTable;
use App\DataTables\ProductUnitDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductAsset;
use App\Models\ProductUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Product::where('deleted_at', null)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = Product::where('created_by', $user->username)->where('deleted_at', null)->get();
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
            // Upload supplier image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('product')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('product')->prefix('product')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload supplier image

            $data = new Product();
            $data->name = $request->name;
            $data->image = $image;
            $data->description = $request->description;
            $data->buying_price = $request->buying_price;
            $data->selling_price = $request->selling_price;
            $data->unit_id = $request->unit_id;
            $data->color_id = $request->color_id;
            $data->size_id = $request->size_id;
            $data->brand_id = $request->brand_id;
            $data->opening_stock = $request->opening_stock == (null || 0) ? 1 : $request->opening_stock;
            $data->group_id = $request->group_id;
            $data->carton = $request->carton == (null || 0) ? 1 : $request->carton;
            $data->stock_warning = $request->stock_warning == (null || 0) ? 1 : $request->stock_warning;
            $data->created_by = $request->created_by;
            $data->save();

            $responseData = [
                'message' => 'Product added successfully',
                'data' => $data,
            ];
            return response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Product::findOrFail($id);
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
        try {
            $data = Product::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = Product::findOrFail($id);

            // Upload supplier image
            $file = new FileManager();
            if ($request->image) {
                if ($data->image != null) {
                    Storage::disk('product')->delete($data->image);
                }
                $photo = $request->image;
                $file->folder('product')->prefix('product')->upload($photo) ? $data->image = $file->getName() : null;
            }
            // Upload supplier image

            $data->name = $request->name;
            $data->description = $request->description;
            $data->buying_price = $request->buying_price;
            $data->selling_price = $request->selling_price;
            $data->unit_id = $request->unit_id;
            $data->color_id = $request->color_id;
            $data->size_id = $request->size_id;
            $data->brand_id = $request->brand_id;
            $data->opening_stock = $request->opening_stock == (null || 0) ? 1 : $request->opening_stock;
            $data->group_id = $request->group_id;
            $data->carton = $request->carton == (null || 0) ? 1 : $request->carton;
            $data->stock_warning = $request->stock_warning == (null || 0) ? 1 : $request->stock_warning;
            $data->updated_by = $request->updated_by;
            $data->save();

            $responseData = [
                'message' => 'Product updated successfully',
                'data' => $data,
            ];
            return response()->json(['message' => 'Product Updated Successfully!', $responseData], 200);
        } catch (\Throwable $th) {
            return response()->json($th, 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            /**
             * For the delete log
             * 1. Model Name
             * 2. Row ID
             */
            $this->deleteLog(Product::class, $id);

            return response()->json(['message' => 'Product deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json($th, 422);
        }
    }
}
