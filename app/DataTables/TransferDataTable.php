<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransferDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'transfer-create']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="editReceive(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'transfer-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
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
            ->rawColumns(['action', 'dt_id', 'client_id', 'printable', 'description']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $model = $model->where('transaction_type', 'transfer')->latest()->newQuery();
        if (request()->starting_date && request()->ending_date) {
            $model->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
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
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.sl')),
            Column::make('date')->title('Date')->addClass('text-center')->title(__('messages.date')),
            Column::make('id')->title('Voucher No')->addClass('text-center')->orderable(false)->title(__('messages.id_no')),
            Column::make('description')->title('Description')->addClass('text-center')->orderable(false)->title(__('messages.description')),
            Column::make('amount')->title('Amount')->addClass('text-center')->orderable(false)->title(__('messages.amount')),
            Column::computed('printable')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.printable')),
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
        return 'Transfer_' . date('YmdHis');
    }
}
