<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\DataTables\DepartmentDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentDataTable $dataTable)
    {
        $pageTitle = __('messages.staff') . ' ' . __('messages.department') . ' ' . __('messages.list');
        return $dataTable->render('user.staff.department.index', compact('pageTitle'));
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
    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new Department();
            $data->name = $request->name;
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Department Added Successfully!', 'success');
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
        $data = Department::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $data = Department::findOrFail($id);
            $data->name = $request->name;
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Department Updated Successfully!', 'success');
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
        $this->deleteLog(Department::class, $id);

        toast('Department Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
