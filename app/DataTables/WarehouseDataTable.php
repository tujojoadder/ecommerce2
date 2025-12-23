<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WarehouseDataTable extends DataTable
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
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })

            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'warehouse-edit']) ? '<a href="javascript:;" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'warehouse-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
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
    public function query(Warehouse $model): QueryBuilder
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
            Column::make('id'),
            Column::make('name'),
            Column::make('address'),
            Column::make('phone'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Warehouse_' . date('YmdHis');
    }
}
