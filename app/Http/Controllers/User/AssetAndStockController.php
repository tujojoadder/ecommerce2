<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\DataTables\AssetAndStockDataTable;
use Illuminate\Http\Request;
use App\Models\AssetAndStock;
use App\Http\Requests\AssetAndStockRequest;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class AssetAndStockController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(AssetAndStockDataTable $dataTable)
    {
        $queryString = $_SERVER['QUERY_STRING'];
        if (request()->has('stock-list')) {
            $pageTitle = __('messages.stock') . ' ' . __('messages.list');
        }
        if (request()->has('asset-list')) {
            $pageTitle = __('messages.asset') . ' ' . __('messages.list');
        }
        return $dataTable->render('user.asset-and-stock.index', compact('pageTitle'));
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
    public function store(AssetAndStockRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new AssetAndStock();
            $data->asset_type = $request->asset_type;
            $data->date = bnToEnDate($request->date);
            $data->supplier_id = $request->supplier_id;
            $data->product_id = $request->product_id;
            $data->unit = $request->unit;
            $data->quantity = $request->quantity;
            $data->rate = $request->rate;
            $data->total_amount = $request->total_amount;
            $data->account = $request->account;
            $data->category = $request->category;
            $data->chart_of_account_id = $request->chart_of_account_id;
            $data->chart_of_account_group_id = $request->chart_of_account_group_id;
            $data->voucher_no = $request->voucher_no;
            $data->id_no = $request->id_no;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Asset And Stock Added Successfully!', 'success');
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
        $data = AssetAndStock::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssetAndStockRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = AssetAndStock::findOrFail($id);
            $data->asset_type = $request->asset_type;
            $data->date = bnToEnDate($request->date);
            $data->supplier_id = $request->supplier_id;
            $data->product_id = $request->product_id;
            $data->unit = $request->unit;
            $data->quantity = $request->quantity;
            $data->rate = $request->rate;
            $data->total_amount = $request->total_amount;
            $data->account = $request->account;
            $data->category = $request->category;
            $data->chart_of_account_id = $request->chart_of_account_id;
            $data->chart_of_account_group_id = $request->chart_of_account_group_id;
            $data->voucher_no = $request->voucher_no;
            $data->id_no = $request->id_no;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Asset And Stock Added Successfully!', 'success');
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
        $this->deleteLog(AssetAndStock::class, $id);

        toast('Asset And Stock Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
