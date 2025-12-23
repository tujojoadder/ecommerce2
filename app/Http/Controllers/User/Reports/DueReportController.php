<?php

namespace App\Http\Controllers\User\Reports;

use App\DataTables\DueReportDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\InvoiceTrait;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;

class DueReportController extends Controller
{
    // use InvoiceTrait;
    use BalanceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "All Due Report";
        if (request()->ajax()) {
            if (request()->client_id) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('id', request()->client_id);
            } else if (request()->client_group) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('group_id', request()->client_group);
            } else {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function ($row) {
                    $html = "<div><p class='mb-0'><strong>Name : </strong>" . $row->client_name . "</p><p class='mb-0'><strong>Address : </strong>" . $row->address . "</p></div>";
                    return $html;
                })
                ->addColumn('previous_due', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        return number_format(0, 2);
                    } else {
                        return $row->previous_due ?? number_format(0, 2);
                    }
                })
                ->addColumn('sales_amount', function ($row) {
                    return $row->sales;
                })
                ->addColumn('total_bill', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        $previousDue = 0.00;
                    } else {
                        $previousDue = $row->previous_due;
                    }
                    return $row->sales + $previousDue;
                })
                ->addColumn('collection', function ($row) {
                    return $row->receive;
                })
                ->addColumn('sales_return', function ($row) {
                    return $row->sales_return;
                })
                ->addColumn('return', function ($row) {
                    return $row->money_return;
                })
                ->addColumn('due', function ($row) {
                    return $row->due;
                })
                ->addColumn('advance', function ($row) {
                    $due = $row->due;
                    if ($due < 0) {
                        return abs($due);
                    } else {
                        return 0;
                    }
                })
                ->rawColumns(['client', 'previous_due', 'sales_amount', 'sales_return', 'total_bill', 'collection', 'return', 'due', 'advance'])
                ->make(true);
        }
        return view('user.reports.due-report.index', compact('pageTitle'));
    }

    public function customerwiseReport()
    {
        $pageTitle = __('messages.client') . " Due Report";
        if (request()->ajax()) {
            if (request()->client_id) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('id', request()->client_id)->latest();
            } else if (request()->client_group) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('group_id', request()->client_group)->latest();
            } else {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->latest();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function ($row) {
                    $html = "<div><p class='mb-0'><strong>Name : </strong>" . $row->client_name . "</p><p class='mb-0'><strong>Address : </strong>" . $row->address . "</p></div>";
                    return $html;
                })
                ->addColumn('previous_due', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        return number_format(0, 2);
                    } else {
                        return $row->previous_due ?? number_format(0, 2);
                    }
                })
                ->addColumn('sales_amount', function ($row) {
                    return $row->sales;
                })
                ->addColumn('total_bill', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        $previousDue = 0.00;
                    } else {
                        $previousDue = $row->previous_due;
                    }
                    return $row->sales + $previousDue;
                })
                ->addColumn('collection', function ($row) {
                    return $row->receive;
                })
                ->addColumn('sales_return', function ($row) {
                    return $row->sales_return;
                })
                ->addColumn('return', function ($row) {
                    return $row->money_return;
                })
                ->addColumn('due', function ($row) {
                    return $row->due;
                })
                ->addColumn('advance', function ($row) {
                    $due = $row->due;
                    if ($due < 0) {
                        return abs($due);
                    } else {
                        return 0;
                    }
                })
                ->rawColumns(['client', 'previous_due', 'sales_amount', 'sales_return', 'total_bill', 'collection', 'return', 'due', 'advance'])
                ->make(true);
        }
        return view('user.reports.due-report.index', compact('pageTitle'));
    }

    public function groupwiseReport()
    {
        $pageTitle = "Group Wise Due Report";
        if (request()->ajax()) {
            if (request()->client_id) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('id', request()->client_id);
            } else if (request()->client_group) {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0)->where('group_id', request()->client_group);
            } else {
                $data = Client::where('status', 1)->where('due', '>', 0)->orWhere('due', '<', 0);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function ($row) {
                    $html = "<div><p class='mb-0'><strong>Name : </strong>" . $row->client_name . "</p><p class='mb-0'><strong>Address : </strong>" . $row->address . "</p></div>";
                    return $html;
                })
                ->addColumn('previous_due', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        return number_format(0, 2);
                    } else {
                        return $row->previous_due ?? number_format(0, 2);
                    }
                })
                ->addColumn('sales_amount', function ($row) {
                    return $row->sales;
                })
                ->addColumn('total_bill', function ($row) {
                    if ((request()->starting_date != '') && (request()->ending_date != '')) {
                        $previousDue = 0.00;
                    } else {
                        $previousDue = $row->previous_due;
                    }
                    return $row->sales + $previousDue;
                })
                ->addColumn('collection', function ($row) {
                    return $row->receive;
                })
                ->addColumn('sales_return', function ($row) {
                    return $row->sales_return;
                })
                ->addColumn('return', function ($row) {
                    return $row->money_return;
                })
                ->addColumn('due', function ($row) {
                    return $row->due;
                })
                ->addColumn('advance', function ($row) {
                    $due = $row->due;
                    if ($due < 0) {
                        return abs($due);
                    } else {
                        return 0;
                    }
                })
                ->rawColumns(['client', 'previous_due', 'sales_amount', 'total_bill', 'collection', 'return', 'due', 'advance'])
                ->make(true);
        }
        return view('user.reports.due-report.index', compact('pageTitle'));
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
