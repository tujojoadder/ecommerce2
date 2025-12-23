<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\SoftwareStatus;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SoftwareManagementDataTable extends DataTable
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
            ->editColumn('key', function ($row) {
                return $row->key ?? '---';
            })
            ->editColumn('invoice_id', function ($row) {
                return $row->invoice_id ?? '---';
            })
            ->editColumn('package_id', function ($row) {
                return $row->package_id ?? '---';
            })
            ->editColumn('created_at', function ($row) {
                return enDateFormat($row->created_at);
            })
            ->editColumn('admin_id', function ($row) {
                return $row->admin_id ?? '---';
            })
            ->addColumn('action', function ($row) {
                $editbtn = '<a href="javascript:;" id="languageEditBtn" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>';

                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['key', 'invoice_id', 'package_id', 'admin_id', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SoftwareStatus $model): QueryBuilder
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
                Button::make('csv'),
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
            Column::make('dt_id')->addClass('text-center'),
            Column::make('key')->addClass('text-center')->orderable(false),
            Column::make('invoice_id')->addClass('text-center')->orderable(false),
            Column::make('package_id')->addClass('text-center')->orderable(false),
            Column::make('admin_id')->addClass('text-center')->orderable(false),
            Column::make('created_at')->addClass('text-center')->title('Date')->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SiteKeyword_' . date('YmdHis');
    }
}
