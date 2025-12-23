<?php

namespace App\Http\Controllers\User\Products;

use App\DataTables\ProductUnitDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Requests\ProductUnitRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductUnitController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductUnitDataTable $dataTable)
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.unit');
        return $dataTable->render('user.products.product.unit.index', compact('pageTitle'));
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
    public function store(ProductUnitRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ProductUnit;
            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();
            DB::commit();

            toast('Product Unit Added Successfully!', 'success');
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
        $data = ProductUnit::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUnitRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $data = ProductUnit::findOrFail($id);
            $data->name = $request->name;
            $data->save();

            DB::commit();

            toast('Product Unit Updated Successfully!', 'success');
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
        $this->deleteLog(ProductUnit::class, $id);

        toast('Product Unit Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
