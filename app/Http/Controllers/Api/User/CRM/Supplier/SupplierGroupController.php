<?php

namespace App\Http\Controllers\Api\User\CRM\Supplier;

use App\DataTables\SupplierGroupDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Models\SupplierGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierGroupController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = SupplierGroup::where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getGroupByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = SupplierGroup::where('created_by', $user->username)->where('deleted_at', null)->latest()->get();
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
            $this->validate($request, [
                'name' => ['required', 'string'],
            ]);
            $data = new SupplierGroup($request->all());
            $data->created_by = $request->created_by;
            $data->save();

            return response()->json(['message' => 'Supplier added successfully!', 'data' => $data], 200);
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
            $data = SupplierGroup::findOrFail($id);
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
        $data = SupplierGroup::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->validate($request, [
                'name' => ['required', 'string'],
            ]);
            $data = SupplierGroup::findOrFail($id);
            $data->name = $request->name;
            $data->updated_by = $request->updated_by;
            $data->save();
            return response()->json(['message' => 'Supplier group updated successfully!', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
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
            $this->deleteLog(SupplierGroup::class, $id);
            return response()->json(['message' => 'Supplier group deleted Successfully!'], 202);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }
}
