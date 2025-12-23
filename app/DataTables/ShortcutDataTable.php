<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\ShortcutMenu;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShortcutDataTable extends DataTable
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
            ->addColumn('title', function ($row) {
                $title = $row->title;
                return $title;
            })
            ->addColumn('address', function ($row) {
                $address = $row->address;
                return $address;
            })
            ->addColumn('icon', function ($row) {
                return $row->icon;
            })
            ->addColumn('bg_color', function ($row) {
                return '<div class="d-flex justify-content-center"><div class="border border-dark rounded-circle my-1" style="height: 30px !important; width: 30px !important; background-color: ' . $row->bg_color . '"></div></div>';
            })
            ->addColumn('text_color', function ($row) {
                return '<div class="d-flex justify-content-center"><div class="border border-dark rounded-circle my-1" style="height: 30px; width: 30px; background-color: ' . $row->text_color . '"></div></div>';
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })

            ->addColumn('action', function ($row) {
                $editbtn = '<a href="javascript:;" id="incomeCategoryEditBtn" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>';
                $deletebtn = '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'icon', 'image', 'bg_color', 'text_color']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ShortcutMenu $model): QueryBuilder
    {
        return $model->where('deleted_at', null)->latest()->newQuery();
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
                Button::make('pdf'),
                Button::make('print'),
                Button::make('excel'),
                // Button::make('colvis')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('title')->addClass('text-center')->title(__('messages.title')),
            Column::make('address')->addClass('text-center')->title(__('messages.address')),
            Column::make('icon')->addClass('text-center')->title(__('messages.icon')),
            Column::make('bg_color')->addClass('text-center')->title(__('messages.bg_color')),
            Column::make('text_color')->addClass('text-center')->title(__('messages.text_color')),
            Column::make('created_at')->title(__('messages.created_at')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
