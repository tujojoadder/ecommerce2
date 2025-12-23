<?php

namespace App\Http\Controllers\User\Products;

use App\Http\Controllers\Controller;
use App\DataTables\ProductGroupDataTable;
use App\Models\ProductGroup;
use App\Http\Requests\ProductGroupRequest;
use App\Helpers\Traits\DeleteLogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductGroupController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */

    public function index(ProductGroupDataTable $dataTable)
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.group');
        return $dataTable->render('user.products.product.group.index', compact('pageTitle'));
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
    public function store(ProductGroupRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ProductGroup();
            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();
            DB::commit();

            toast('Product Group Added Successfully!', 'success');
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
        $data = ProductGroup::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGroupRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $data = ProductGroup::findOrFail($id);
            $data->name = $request->name;
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
        $this->deleteLog(ProductGroup::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
