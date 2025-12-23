<?php

namespace App\Http\Controllers\User\Reports;

use App\DataTables\DepositDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositReportsController extends Controller
{
    public function all(DepositDataTable $dataTable)
    {
        $pageTitle = __('messages.all') . ' ' . __('messages.deposit') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.deposit.all', compact('pageTitle'));
    }
    public function categoryWise(DepositDataTable $dataTable)
    {
        $pageTitle = __('messages.category') . ' ' . __('messages.wise') . ' ' . __('messages.deposit') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.deposit.category-wise', compact('pageTitle'));
    }
    public function customerWise(DepositDataTable $dataTable)
    {
        $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.deposit') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.deposit.customer-wise', compact('pageTitle'));
    }
}
