<?php

namespace App\Http\Controllers\User\Configuration\ReceiveCategory;

use App\DataTables\ReceiveCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ReceiveCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiveCategoryRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class ReceiveCategoryController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ReceiveCategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.receive') . ' ' . __('messages.category') . ' ' . __('messages.list');
        return $dataTable->render('user.accounts.receive.category.index', compact('pageTitle'));
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
    public function store(ReceiveCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ReceiveCategory;
            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Receive Category Added Successfully!', 'success');
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
        $data = ReceiveCategory::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceiveCategoryRequest $request, string $id)
    {
        $data = ReceiveCategory::findOrFail($id);
        $data->name = $request->name;
        $data->created_by = Auth::user()->created_by;
        $data->save();

        toast('Receive Category Updated Successfully!', 'success');
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
        $this->deleteLog(ReceiveCategory::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
