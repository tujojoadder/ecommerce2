<?php

namespace App\Http\Controllers\User\Reports;

use App\DataTables\ProductSalesReportDataTable;
use App\DataTables\SalesReportDataTable;
use App\DataTables\SalesReportTransactionWiseDataTable;
use App\Helpers\Traits\CartonTrait;
use App\Helpers\Traits\ProductTrait;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SalesReportController extends Controller
{
    use CartonTrait, ProductTrait;
    public function index(SalesReportTransactionWiseDataTable $dataTable)
    {
        if (request()->has('customer-search')) {
            $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else if (request()->has('group-search')) {
            $pageTitle = __('messages.group') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else {
            $pageTitle = __('messages.sales') . ' ' . __('messages.report');
        }
        return $dataTable->render('user.reports.sales.index', compact('pageTitle'));
    }
    public function sales(SalesReportTransactionWiseDataTable $dataTable)
    {
        if (request()->has('customer-search')) {
            $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else if (request()->has('group-search')) {
            $pageTitle = __('messages.group') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else if (request()->has('daily-search')) {
            $pageTitle = __('messages.daily') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else {
            $pageTitle = __('messages.sales') . ' ' . __('messages.report');
        }
        return $dataTable->render('user.reports.sales.sales', compact('pageTitle'));
    }
    public function salesCustomerWise(SalesReportTransactionWiseDataTable $dataTable)
    {
        if (request()->has('customer-search')) {
            if (request()->client_id) {
                $client = Client::findOrFail(request()->client_id);
                $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report')  . ' | (' . $client->client_name . ')';
            } else {
                $pageTitle = __('messages.customer') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
            }
        } else if (request()->has('group-search')) {
            $pageTitle = __('messages.group') . ' ' . __('messages.wise') . ' ' . __('messages.sales') . ' ' . __('messages.report');
        } else {
            $pageTitle = __('messages.sales') . ' ' . __('messages.report');
        }
        return $dataTable->render('user.reports.sales.customer-wise', compact('pageTitle'));
    }
    public function productWise(SalesReportTransactionWiseDataTable $dataTable)
    {
        $pageTitle = "Product Wise Sales Reports";
        return $dataTable->render('user.reports.sales.product-wise', compact('pageTitle'));
    }
}
