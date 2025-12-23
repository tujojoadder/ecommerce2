<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\ChequeSchedule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Gate;

class ChequeScheduleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('dt_id', function ($row) {
                static $count = 1;
                return $count++;
                // return $this->dt_index($row);
            })
            ->addColumn('name', function ($row) {
                $name = $row->name;
                return $name;
            })
            ->editColumn('date', function ($row) {
                return date('d M Y', strtotime($row->date));
            })

            ->editColumn('supplier_id', function ($row) {
                return $row->supplier->supplier_name ?? '';
            })

            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'supplier-group-edit']) ?
                    '<a href="' . route('user.cheque.schudule.edit', $row->id) . '" id="incomeCategoryEditBtn" class="btn btn-sm mx-1 btn-info"><i class="fas fa-pen-nib"></i></a>' : '';

                $deletebtn = Gate::any(['access-all', 'supplier-group-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ChequeSchedule $model): QueryBuilder
    {
        return $model->newQuery();
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
                // Button::make('csv'),
                // Button::make('pdf'),
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
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('date')->addClass('text-center')->title(__('messages.date')),
            Column::make('supplier_id')->addClass('text-center')->title(__('messages.supplier')),
            Column::make('bank_name')->addClass('text-center')->title(__('messages.bank')),
            Column::make('amount')->addClass('text-center')->title(__('messages.amount')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->title(__('messages.action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SupplierChequeSchedule_' . date('YmdHis');
    }
}
