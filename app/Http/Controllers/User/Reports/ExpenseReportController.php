<?php

namespace App\Http\Controllers\User\Reports;

use App\DataTables\ExpenseReportDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    public function all(ExpenseReportDataTable $dataTable)
    {
        $pageTitle = __('messages.all') . ' ' . __('messages.expense') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.expense.all', compact('pageTitle'));
    }
    public function categoryWise(ExpenseReportDataTable $dataTable)
    {
        $pageTitle = __('messages.category') . ' ' . __('messages.wise') . ' ' . __('messages.expense') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.expense.category-wise', compact('pageTitle'));
    }
    public function subCategoryWise(ExpenseReportDataTable $dataTable)
    {
        $pageTitle = __('messages.subcategory') . ' ' . __('messages.wise') . ' ' . __('messages.expense') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.expense.subcategory-wise', compact('pageTitle'));
    }
    public function customerWise(ExpenseReportDataTable $dataTable)
    {
        $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.expense') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.expense.customer-wise', compact('pageTitle'));
    }
    public function supplierPayment(ExpenseReportDataTable $dataTable)
    {
        $pageTitle = __('messages.supplier') . ' ' . __('messages.payment') . ' ' . __('messages.report');
        return $dataTable->render('user.reports.expense.supplier-payment', compact('pageTitle'));
    }
}
