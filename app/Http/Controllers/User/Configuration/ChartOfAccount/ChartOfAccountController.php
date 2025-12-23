<?php

namespace App\Http\Controllers\User\Configuration\ChartOfAccount;

use App\DataTables\ChartOfAccountDataTable;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChartOfAccountRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;


class ChartOfAccountController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ChartOfAccountDataTable $dataTable)
    {
        $pageTitle = __('messages.chart_of_account').' '.__('messages.list');
        return $dataTable->render('user.config.chart-of-account.index', compact('pageTitle'));
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
    public function store(ChartOfAccountRequest $request)
    {
        $data = new ChartOfAccount();

        $data->name = $request->name;
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
        $data = ChartOfAccount::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChartOfAccountRequest $request, string $id)
    {
        $data = ChartOfAccount::findOrFail($id);
        $data->name = $request->name;
        $data->created_by = Auth::user()->created_by;
        $data->save();

        toast('Income Category Updated Successfully!', 'success');
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
        $this->deleteLog(ChartOfAccount::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
