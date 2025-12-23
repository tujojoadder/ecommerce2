<?php

namespace App\DataTables;

use App\Models\Order;
use App\Helpers\Traits\RowIndex;
use App\Helpers\Traits\StockTrait;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Gate;

class OrderDataTable extends DataTable
{

    use RowIndex;


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('dt_id', function ($row) {
                return $this->dt_index($row);
            })
            ->editColumn('created_at', function ($row) {
                $date = 'Date: ' . date('d M Y', strtotime($row->created_at));
                $time = 'Time: ' . date('h:i:A', strtotime($row->created_at));
                return $date . '<br>' . $time;
            })
            ->addColumn('client_id', function($row){
                $name = 'Name: ' . $row->client->client_name ?? 'N/A';
                $phone = 'Phone: ' . $row->client->phone ?? 'N/A';
                return $name . '<br>' . $phone;
            })
            ->addColumn('status', function($row){
                if($row->order_status == 0){
                    return '<span class="badge bg-dark">Requested</span>';
                }elseif($row->order_status == 1){
                    return '<span class="badge bg-danger">Placed</span>';
                }elseif($row->order_status == 2){
                    return '<span class="badge bg-info">Process</span>';
                }elseif($row->order_status == 3){
                    return '<span class="badge bg-success">Delivered</span>';
                }elseif($row->order_status == 4){
                    return '<span class="badge bg-danger">Rejected</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $buttons = '';

                if ($row->order_status == 0) {
                    // Requested → Only Placed
                    $buttons .= '<a href="'. route('user.order.view', $row->id) .'" class="btn btn-info btn-sm" >View Order</a>';
                    $buttons .= '<button class="btn btn-danger btn-sm" onclick="changeStatus(' . $row->id . ', 1)">Placed Order</button>';
                    $buttons .= '<button class="btn btn-dark btn-sm mt-1" onclick="changeStatus(' . $row->id . ', 4)">Reject Order</button>';
                } elseif ($row->order_status == 1) {
                    // Placed → Process + Reject
                    $buttons .= '<a href="'. route('user.order.view', $row->id) .'" class="btn btn-info btn-sm" >View Order</a>';
                    $buttons .= '<button class="btn btn-info btn-sm" onclick="changeStatus(' . $row->id . ', 2)">Process Order</button>';
                    $buttons .= '<button class="btn btn-dark btn-sm mt-1" onclick="changeStatus(' . $row->id . ', 4)">Reject Order</button>';
                } elseif ($row->order_status == 2) {
                    // Processing → Delivered + Reject
                    $buttons .= '<a href="'. route('user.order.view', $row->id) .'" class="btn btn-info btn-sm" >View Order</a>';
                    $buttons .= '<button class="btn btn-success btn-sm" onclick="changeStatus(' . $row->id . ', 3)">Delivered Order</button>';
                    $buttons .= '<button class="btn btn-dark btn-sm mt-1" onclick="changeStatus(' . $row->id . ', 4)">Reject Order</button>';
                } elseif ($row->order_status == 3) {
                    // Delivered → No action
                    $buttons .= '<a href="'. route('user.order.view', $row->id) .'" class="btn btn-info btn-sm" >View Order</a>';
                    $buttons .= '<span class="badge bg-success">Completed</span>';
                } elseif ($row->order_status == 4) {
                    // Rejected → No action
                    $buttons .= '<a href="'. route('user.order.view', $row->id) .'" class="btn btn-info btn-sm" >View Order</a>';
                    $buttons .= '<span class="badge bg-danger">Rejected</span>';
                }

                return '<div class="d-flex flex-column">' . $buttons . '</div>';
            })


            ->rawColumns(['action', 'id', 'client_id', 'created_at', 'status']);
    }


    public function query(Order $model): QueryBuilder
    {
        $query = $model->newQuery()->latest();


        $query->when(request()->starting_date && request()->ending_date, function ($query) {
            $date = enSearchDate(request()->starting_date, request()->ending_date);
            return $query->whereBetween('created_at', $date);
        });

        $query->when(request()->invoice_id, function ($query) {
            return $query->where('id', request()->invoice_id);
        });

        $query->when(request()->type, function ($query) {
            if(request()->type == 'requested'){
                return $query->where('order_status', 0);
            }
            if(request()->type == 'placed'){
                return $query->where('order_status', 1);
            }
            if(request()->type == 'process'){
                return $query->where('order_status', 2);
            }
            if(request()->type == 'delivered'){
                return $query->where('order_status', 3);
            }
            if(request()->type == 'rejected'){
                return $query->where('order_status', 4);
            }
        });

        return $query;
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('lBfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }


    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }


    protected function filename(): string
    {
        return 'Order_' . date('YmdHis');
    }
}
