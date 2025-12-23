<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\InvoiceItem;
use App\Models\ProductSalesReport;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductSalesReportDataTable extends DataTable
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
            ->addColumn('issued_date', function ($row) {
                return $row->invoice->issued_date ?? '---';
            })
            ->addColumn('product_id', function ($row) {
                return $row->product->name ?? '---';
            })
            ->addColumn('sale_quantity', function ($row) {
                return 0;
            })
            ->addColumn('sale_return_quantity', function ($row) {
                return 0;
            })
            ->addColumn('total_sale_quantity', function ($row) {
                return 0;
            })
            ->rawColumns(['dt_id', 'products', 'unit_id', 'total']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InvoiceItem $model): QueryBuilder
    {
        return $model->with('invoice')
            ->select('*')
            ->fromSub(function ($query) {
                $query->select('product_id')
                    ->distinct()
                    ->from('invoice_items');
            }, 'subquery_alias')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('file-export-datatable')
            ->addTableClass('table-bordered')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->pageLength(50)
            ->orderBy(0, 'asc')
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
            Column::make('issued_date')->title(__('messages.date')),
            Column::make('invoice_id')->title(__('messages.invoice') . ' ' . __('messages.id_no')),
            Column::make('product_id')->title(__('messages.product')),
            Column::make('sale_quantity')->title(__('messages.sales') . ' ' . __('messages.quantity')),
            Column::make('sale_return_quantity')->title(__('messages.sales') . ' ' . __('messages.quantity')),
            Column::make('total_sale_quantity')->title(__('messages.sales') . ' ' . __('messages.total' . ' ' . __('messages.quantity'))),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductSalesReport_' . date('YmdHis');
    }
}
