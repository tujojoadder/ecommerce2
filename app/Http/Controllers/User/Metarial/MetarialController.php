<?php

namespace App\Http\Controllers\User\Metarial;

use App\DataTables\StaffsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetarialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.metarial').' '.__('messages.list');
        return $dataTable->render('user.metarial.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function metarialStock(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.metarial').' '.__('messages.stock');
        return $dataTable->render('user.metarial.metarial-list', compact('pageTitle'));
    }

    //metarial Group
    public function metarialgroup(StaffsDataTable $dataTable)
    {
        $pageTitle = __('messages.metarial').' '.__('messages.group');
        return $dataTable->render('user.metarial.metarial-group', compact('pageTitle'));
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
    public function buyMetarial(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Purchase Raw Metarial';
        return $dataTable->render('user.metarial.metarial-buy', compact('pageTitle'));

    }
    public function stockMetarial(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Raw Metarial Stock';
        return $dataTable->render('user.metarial.stock', compact('pageTitle'));

    }
    public function groupMetarial(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Raw Metarial Group';
        return $dataTable->render('user.metarial.metarial-group', compact('pageTitle'));

    }
}
