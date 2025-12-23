<?php

namespace App\Http\Controllers\User;

use App\DataTables\StaffsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BatchProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.batch').' '.__('messages.product').' '.__('messages.list');
        return $dataTable->render('user.batch-product.index', compact('pageTitle'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.batch').' '.__('messages.product').' '.__('messages.create');
        return view('user.batch-product.create', compact('pageTitle'));
    }
    //Batch Product Transfer
    public function BatchProductTransfer(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.transfer').' '.__('messages.product').' '.__('messages.transfer');
        return $dataTable->render('user.batch-product.transfer', compact('pageTitle'));
    }
    //Batch Product Transfer Report
    public function BatchProductTransferReport(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.batch').' '.__('messages.product').' '.__('messages.transfer').' '.__('messages.report');
        return $dataTable->render('user.batch-product.transfer-report', compact('pageTitle'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
