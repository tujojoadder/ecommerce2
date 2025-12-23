<?php

namespace App\Http\Controllers\User\Configuration\ReceiveCategory;

use App\DataTables\ReceiveSubcategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ReceiveSubcategory;
use App\Models\ReceiveCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiveSubcategoryRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class ReceiveSubcategoryController extends Controller
{
    use DeleteLogTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ReceiveSubcategoryDataTable $dataTable)
    {

        $pageTitle = __('messages.receive') . ' ' . __('messages.subcategory') . ' ' . __('messages.list');
        $category = ReceiveCategory::get();
        return $dataTable->render('user.accounts.receive.subcategory.index', compact('pageTitle', 'category'));
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
    public function store(ReceiveSubcategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new ReceiveSubcategory();

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
        $data = ReceiveSubcategory::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceiveSubcategoryRequest $request, string $id)
    {
        $data = ReceiveSubcategory::findOrFail($id);
        $data->name = $request->name;
        $data->category_id = $request->category_id;
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
        $this->deleteLog(ReceiveSubcategory::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
