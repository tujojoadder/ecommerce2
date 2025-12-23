<?php

namespace App\Http\Controllers\User;

use App\DataTables\BranchDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */

    public function index(BranchDataTable $dataTable)
    {
        $pageTitle = __('messages.branch');
        return $dataTable->render('user.branch.index', compact('pageTitle'));
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
    public function store(BranchRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new Branch();
            $data->name = $request->name;
            $data->address = $request->address;
            $data->created_by = Auth::user()->username;
            $data->save();
            DB::commit();

            toast('Branch Added Successfully!', 'success');
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
        $data = Branch::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $data = Branch::findOrFail($id);
            $data->name = $request->name;
            $data->address = $request->address;
            $data->updated_by = Auth::user()->username;
            $data->save();
            DB::commit();

            toast('Branch Updated Successfully!', 'success');
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
        $this->deleteLog(Branch::class, $id);

        toast('Branch Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
