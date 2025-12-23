<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\SiteKeyword;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SiteKeywordDataTable extends DataTable
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
            ->editColumn('arabic', function ($row) {
                return $row->arabic ?? '---';
            })
            ->editColumn('bangla', function ($row) {
                return $row->bangla ?? '---';
            })
            ->editColumn('english', function ($row) {
                return $row->english ?? '---';
            })
            ->editColumn('hindi', function ($row) {
                return $row->hindi ?? '---';
            })
            ->addColumn('action', function ($row) {
                $editbtn = '<a href="javascript:;" id="languageEditBtn" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>';
                $deletebtn = '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'product_details', 'image']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SiteKeyword $model): QueryBuilder
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
            Column::make('id')->addClass('text-center')->orderable(false)->addClass('bg-white')->title(__('messages.id_no')),
            Column::make('keyword')->addClass('text-center')->title(__('messages.keyword')),
            Column::make('arabic')->addClass('text-center'),
            Column::make('bangla')->addClass('text-center'),
            Column::make('english')->addClass('text-center'),
            Column::make('hindi')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center align-middle'),
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
