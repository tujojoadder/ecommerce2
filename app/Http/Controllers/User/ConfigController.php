<?php

namespace App\Http\Controllers\User;

use App\DataTables\StaffsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    //config income sector
    public function incomeCategory(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Income Sector';
        return $dataTable->render('user.config.income-category', compact('pageTitle'));
    }
    //config expense sector
    public function expenseSector(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Expense Sector';
        return $dataTable->render('user.config.expense-sector', compact('pageTitle'));
    }
    //config chartof account
    public function chartOfAccount(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Chart Of Account';
        return $dataTable->render('user.config.chart-of-account', compact('pageTitle'));
    }
    //config shortcut Menu
    public function shortcutMenu(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Shortcut Menu';
        return $dataTable->render('user.config.shortcut-menu', compact('pageTitle'));
    }
    //config payment Method
    public function paymentMethod(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Payment Method';
        return $dataTable->render('user.config.payment-method', compact('pageTitle'));
    }

    //config company Information
    public function companyInformation(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Company Information';
        return $dataTable->render('user.config.company-information', compact('pageTitle'));
    }
    //config permission to use
    public function permissionToUse(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Permission To Use';
        return $dataTable->render('user.config.permission-to-use', compact('pageTitle'));
    }
    //config bank
    public function bank(StaffsDataTable $dataTable)
    {
        $pageTitle = 'Bank Name';
        return $dataTable->render('user.config.bank', compact('pageTitle'));
    }
    //config settings
    public function settings(StaffsDataTable $dataTable)
    {
        $pageTitle = 'settings';
        return $dataTable->render('user.config.settings', compact('pageTitle'));
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
