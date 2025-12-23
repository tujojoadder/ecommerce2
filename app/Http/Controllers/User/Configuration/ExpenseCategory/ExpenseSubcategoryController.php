<?php

namespace App\Http\Controllers\User\Configuration\ExpenseCategory;

use App\DataTables\ExpenseSubcategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ExpenseSubcategory;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseSubcategoryRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class ExpenseSubcategoryController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ExpenseSubcategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.expense') . ' ' . __('messages.subcategory') . ' ' . __('messages.list');
        $category = ExpenseCategory::get();
        return $dataTable->render('user.config.expense-category.expense-subcategory', compact('pageTitle', 'category'));
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
    public function store(ExpenseSubcategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ExpenseSubcategory();

            $data->name = $request->name;
            $data->category_id = $request->category_id;
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
        $data = ExpenseSubcategory::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseSubcategoryRequest $request, string $id)
    {
        $data = ExpenseSubcategory::findOrFail($id);
        $data->name = $request->name;
        $data->category_id = $request->category_id;
        $data->created_by = Auth::user()->created_by;
        $data->save();

        toast('Expense Subategory Updated Successfully!', 'success');
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
        $this->deleteLog(ExpenseSubcategory::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
