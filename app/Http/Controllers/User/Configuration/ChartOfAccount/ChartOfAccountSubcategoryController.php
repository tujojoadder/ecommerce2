<?php

namespace App\Http\Controllers\User\Configuration\ChartOfAccount;

use App\DataTables\ChartOfAccountSubcategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountGroup;
use App\Models\ChartOfAccountSubcategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChartOfAccountSubcategoryRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;

class ChartOfAccountSubcategoryController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ChartOfAccountSubcategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.chart_of_account').' '.__('messages.subcategory').' '.__('messages.list');

        $chart = ChartOfAccount::get();
        $group = ChartOfAccountGroup::get();
        return $dataTable->render('user.config.chart-of-account.chart-subcategory', compact('pageTitle','chart','group'));
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
    public function store(ChartOfAccountSubcategoryRequest $request)
    {
        $data = new ChartOfAccountSubcategory();

        $data->name = $request->name;
        $data->chart_id = $request->chart_id;
        $data->group_id = $request->group_id;
        $data->created_by = Auth::user()->created_by;
        $data->save();


        toast('Subcategory Added Successfully!', 'success');
        return response()->json($data);
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
        $data = ChartOfAccountSubcategory::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChartOfAccountSubcategoryRequest $request, string $id)
    {
        $data = ChartOfAccountSubcategory::findOrFail($id);
        $data->chart_id = $request->chart_id;
        $data->name = $request->name;
        $data->group_id = $request->group_id;
        $data->created_by = Auth::user()->created_by;
        $data->save();

        toast('Subcategory  Updated Successfully!', 'success');
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
        $this->deleteLog(ChartOfAccountSubcategory::class, $id);

        toast('Chart Of Account Subcategory Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
