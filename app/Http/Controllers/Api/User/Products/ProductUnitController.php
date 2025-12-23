<?php

namespace App\Http\Controllers\Api\User\Products;

use App\DataTables\ProductUnitDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Requests\ProductUnitRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductUnitController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = ProductUnit::where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getUnitByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = ProductUnit::where('created_by', $user->username)->where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);;
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
            $data = new ProductUnit;
            $data->name = $request->name;
            $data->created_by = $request->created_by;
            $data->save();
            return response()->json(['message' => 'Unit Added Successfully!', 'data' => $data], 200);
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
            $data = ProductUnit::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Unit Not Found!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = ProductUnit::findOrFail($id);
            $data->name = $request->name;
            $data->updated_by = $request->updated_by;
            $data->save();
            return response()->json(['message' => 'Product Unit Updated Successfully!', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
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
            $this->deleteLog(ProductUnit::class, $id);

            return response()->json(['message' => 'Unit Deleted Successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }
}
