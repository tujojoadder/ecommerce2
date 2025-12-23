<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SupplierPaymentDataTable extends DataTable
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
            ->addColumn('sl', function ($row) {
                return $this->dt_index($row);
            })
            ->addColumn('date', function ($row) {
                return date('d M Y', strtotime($row->date)) ?? date('d M Y', strtotime($row->created_at));
            })
            ->editColumn('account_id', function ($row) {
                return $row->account->title ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'supplier-payment-edit']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="edit(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'supplier-payment-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            // ->addColumn('printable', function ($row) {
            //     $print = '<a href="javascript:;" class="btn btn-sm mx-1 btn-primary" onclick="printInvoice(' . $row->id . ')"><i class="fas fa-print"></i></a>';
            //     $dropdown = '
            //         <div class="text-center">
            //         ' . $print . '
            //         </dvi>
            //     ';
            //     return $dropdown;
            // })
            ->rawColumns(['action', 'sl', 'printable']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->where('type', 'cost')->where('transaction_type', 'purchase')->where('deleted_at', null)->latest()->newQuery();
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
            Column::make('sl')->addClass('bg-white text-center')->width('5%')->title(__('messages.sl')),
            Column::make('date')->addClass('text-center')->title(__('messages.date')),
            Column::make('id')->addClass('text-center')->orderable(false)->title(__('messages.id_no')),
            // Column::make('category_id')->title('Category')->addClass('text-center')->orderable(false),
            Column::make('account_id')->addClass('text-center')->orderable(false)->title(__('messages.account')),
            Column::make('cheque_no')->addClass('text-center')->orderable(false)->title(__('messages.check_no')),
            Column::make('description')->addClass('text-center')->orderable(false)->title(__('messages.description')),
            Column::make('amount')->addClass('text-center')->orderable(false)->title(__('messages.amount')),
            // Column::computed('printable')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
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
        return 'SupplierPayment_' . date('YmdHis');
    }
}
