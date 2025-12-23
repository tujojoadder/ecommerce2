<?php

namespace App\Http\Controllers\User\Configuration\ExpenseCategory;

use App\DataTables\ExpenseCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseCategoryRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ExpenseCategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.expense') . ' ' . __('messages.category') . ' ' . __('messages.list');
        return $dataTable->render('user.config.expense-category.index', compact('pageTitle'));
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
    public function store(ExpenseCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ExpenseCategory();

            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Subcategory Added Successfully!', 'success');
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
        $data = ExpenseCategory::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryRequest $request, string $id)
    {
        $data = ExpenseCategory::findOrFail($id);
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
        $this->deleteLog(ExpenseCategory::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
