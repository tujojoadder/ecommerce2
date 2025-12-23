<?php

namespace App\Http\Controllers\Api\User\Products;

use App\Http\Controllers\Controller;
use App\DataTables\ProductGroupDataTable;
use App\Models\ProductGroup;
use App\Http\Requests\ProductGroupRequest;
use App\Helpers\Traits\DeleteLogTrait;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductGroupController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $data = ProductGroup::where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getGroupByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = ProductGroup::where('created_by', $user->username)->where('deleted_at', null)->latest()->get();
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
            $data = new ProductGroup();
            $data->name = $request->name;
            $data->created_by = $request->created_by;
            $data->save();

            return response()->json(['message' => 'Group Added Successfully!', $data], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = ProductGroup::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = ProductGroup::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGroupRequest $request, string $id)
    {
        try {
            $data = ProductGroup::findOrFail($id);
            $data->name = $request->name;
            $data->updated_by = $request->updated_by;
            $data->save();

            return response()->json(['message' => 'Group Updated Successfully!', $data], 200);
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
            $this->deleteLog(ProductGroup::class, $id);
            return response()->json(['message' => 'Group deleted Successfully!'], 202);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }
}
