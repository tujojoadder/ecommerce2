<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Purchase;
use App\Models\PurchaseInvoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PurchaseInvoiceDataTable extends DataTable
{
    use RowIndex;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('dt_id', function ($row) {
                return $this->dt_index($row);
            })
            ->editColumn('issued_date', function ($row) {
                return bnDateFormat($row->issued_date);
            })
            ->editColumn('supplier_id', function ($row) {
                return $row->supplier_name ?? '---';
            })
            ->addColumn('action', function ($row) {
                $route = request()->is('user/purchase/return/invoice');
                $view = Gate::any(['access-all', 'product-purchase-view']) ? '<a href="' . route('user.purchase.view', $row->id) . '" class="btn btn-sm mx-1 btn-success"><i class="fas fa-eye"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'product-purchase-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                // $edit = '<a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="edit(' . $row->id . ')"><i class="fas fa-pen-alt"></i></a>';
                $edit = Gate::any(['access-all', 'product-purchase-edit']) ? '<a href="' . route('user.purchase.goToEdit', $row->id) . '' . ($route ? '?purchase-return' : '') . '" class="btn btn-sm mx-1 btn-success"><i class="fas fa-pen-alt"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-center">
                    ' . $view . '
                    ' . $deletebtn . '
                    ' . $edit . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->addColumn('printable', function ($row) {
                $print = '<a href="javascript:;" class="btn btn-sm mx-1 btn-primary" onclick="printInvoice(' . $row->id . ')"><i class="fas fa-print"></i></a>';
                $dropdown = '
                    <div class="text-center">
                    ' . $print . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'supplier_id', 'printable', 'description']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Purchase $model): QueryBuilder
    {
        $model = $model->with('product')->where('deleted_at', null)->orderBy('issued_date', 'desc')->newQuery();

        if (request()->is('user/purchase/return*') || request()->is('user/purchase/return/invoice')) {
            $model->where('status', 4);
        } else {
            $model->where('status', 0);
        }
        if (request()->filled('select_supplier_id')) {
            $model->where('supplier_id', request()->select_supplier_id);
        }
        if (request()->filled('starting_date') && request()->filled('ending_date')) {
            $model->whereBetween('issued_date', [enSearchDate(request()->starting_date, request()->ending_date)]);
        }
        if (request()->filled('product_name')) {
            $productName = request()->product_name;
            $model->whereHas('product', function ($query) use ($productName) {
                $query->where('name', 'like', '%' . $productName . '%')
                    ->orWhere('description', 'like', '%' . $productName . '%');
            });
        }
        if (request()->filled('invoice_no')) {
            $model->where('invoice_id', request()->invoice_no);
        }
        return $model;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('file-export-datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('dt_id')->orderable(true)->title(__('messages.id_no')),
            Column::make('issued_date')->addClass('bg-white')->orderable(false)->title(__('messages.date')),
            Column::make('supplier_id')->searchable(false)->orderable(false)->title(__('messages.supplier')),
            Column::make('product_id')->title(__('messages.product')),
            Column::make('buying_price')->title(__('messages.buying') . ' ' . __('messages.price')),
            Column::make('selling_price')->title(__('messages.selling') . ' ' . __('messages.price')),
            Column::make('quantity')->title(__('messages.quantity')),
            Column::make('total_buying_price')->title(__('messages.total')),
            Column::make('description')->title(__('messages.description')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.action'))
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PurchaseInvoice_' . date('YmdHis');
    }
}
