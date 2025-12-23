<?php

namespace App\Http\Controllers\User;

use App\DataTables\WarehouseDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(WarehouseDataTable $dataTable)
    {
        $pageTitle = __('messages.ware_house') . ' ' . __('messages.list');
        return $dataTable->render('user.products.warehouse.index', compact('pageTitle'));
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
    public function store(WarehouseRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new Warehouse($request->all());
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Warehouse Added Successfully!', 'success');
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
        $data = Warehouse::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WarehouseRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = Warehouse::findOrFail($id);
            $data->update($request->except('_token', '_method'));
            $data->updated_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Warehouse Updated Successfully!', 'success');
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
        $this->deleteLog(Warehouse::class, $id);

        toast('Warehouse Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
