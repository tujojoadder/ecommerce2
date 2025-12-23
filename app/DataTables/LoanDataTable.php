<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Loan;
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

class LoanDataTable extends DataTable
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
            ->editColumn('date', function ($row) {
                return bnDateFormat($row->date);
            })
            ->editColumn('invoice_no', function ($row) {
                return $row->invoice->id ?? '';
            })
            ->editColumn('client_id', function ($row) {
                if ($row->transaction_type == 'account') {
                    return 'Account Initial';
                } else {
                    $clientName = $row->client->client_name ?? '---';
                    $clientNumber1 = $row->client->phone ?? '---';
                    return '
                Name: ' . $clientName . ' <br>
                Number: ' . $clientNumber1 . '
                ';
                }
            })
            ->editColumn('bank_id', function ($row) {
                return $row->bank->name ?? '';
            })
            ->editColumn('transaction_type', function ($row) {
                if ($row->transaction_type == 'loan_receive') {
                    return '<span>' . __('messages.loan_receive') . '</span>';
                } else {
                    return '<span>' . __('messages.loan_payment') . '</span>';
                }
            })
            ->addColumn('action', function ($row) {
                if ($row->transaction_type == 'invoice') {
                    $disableOrEnable = 'disabled';
                } else {
                    $disableOrEnable = '';
                }
                $editbtn = Gate::any(['access-all', 'receive-edit']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-info ' . $disableOrEnable . '" onclick="editReceive(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'receive-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger ' . $disableOrEnable . '" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                <div class="d-flex justify-content-between">
                ' . $editbtn . $deletebtn . '
                </dvi>
            ';
                return $dropdown;
            })
            ->addColumn('printable', function ($row) {
                $print = '<a href="javascript:;" class="btn btn-sm mx-1 btn-success" onclick="printReceipt(' . $row->id . ')"><i class="fas fa-print"></i></a>';
                $dropdown = '
                <div class="text-center">
                ' . $print . '
                </dvi>
            ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'client_id', 'printable', 'description', 'transaction_type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $model = $model->newQuery();
        if (request()->type == 'loan-receive') {
            $model->where('transaction_type', 'loan_receive');
        } else {
            $model->where('transaction_type', 'loan_payment');
        }
        if (request()->starting_date && request()->ending_date) {
            $model->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
        }
        if (request()->client_id) {
            $model->where('client_id', request()->client_id);
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
            Column::make('created_at')->addClass('text-center')->title(__('messages.date')),
            Column::make('id')->addClass('text-center')->orderable(false)->title(__('messages.id_no')),
            Column::make('client_id')->addClass('text-start')->orderable(false)->title(__('messages.client')),
            Column::make('description')->addClass('text-center')->orderable(false)->title(__('messages.description')),
            Column::make('amount')->addClass('text-center')->orderable(false)->title(__('messages.amount')),
            Column::computed('printable')->title('Money Receipt')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center print-hide'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center print-hide')
                ->title(__('messages.action'))
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Loan_' . date('YmdHis');
    }
}
