<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SoftwareManagementDataTable;
use App\Http\Requests\SoftwareManagementRequest;
use App\Models\SoftwareStatus;
use Illuminate\Support\Facades\Auth;

class SoftwareManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(SoftwareManagementDataTable $dataTable)
    {
        $pageTitle = "Software Management";
        return $dataTable->render('admin.management.index', compact('pageTitle'));
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
    public function store(SoftwareManagementRequest $request)
    {
        $data = SoftwareStatus::first();
        if ($data) {
            $data->key = $request->key;
            $data->package_id = $request->package_id;
            $data->invoice_id = $request->invoice_id;
            $data->admin_id = $request->admin_id;
            $data->save();
        } else {
            $new_data = new SoftwareStatus;
            $new_data->key = $request->key;
            $new_data->package_id = $request->package_id;
            $new_data->invoice_id = $request->invoice_id;
            $new_data->admin_id = $request->admin_id;
            $new_data->save();
        }
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
        $data = SoftwareStatus::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoftwareManagementRequest $request, string $id)
    {
        $data = SoftwareStatus::findOrFail($id);
        $data->key = $request->key;
        $data->package_id = $request->package_id;
        $data->invoice_id = $request->invoice_id;
        $data->admin_id = 0;
        $data->save();
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
