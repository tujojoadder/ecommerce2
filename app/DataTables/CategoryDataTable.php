<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Traits\RowIndex;
use Illuminate\Support\Facades\Gate;

class CategoryDataTable extends DataTable
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
            ->addColumn('icon', function ($row) {
                if ($row->icon != null) {
                    $asset = asset('storage/category/' . $row->icon);
                } else {
                    $asset = asset('dashboard/img/user-bg.png');
                }
                return '<img src="'. $asset .'" style="width: 20px">';
            })
            ->addColumn('banner', function ($row) {
                if ($row->banner != null) {
                    $asset = asset('storage/category/' . $row->banner);
                } else {
                    $asset = asset('dashboard/img/user-bg.png');
                }
                return '<img src="'. $asset .'" style="width: 100px">';
            })
            ->addColumn('banner2', function ($row) {
                if ($row->banner2 != null) {
                    $asset = asset('storage/category/' . $row->banner2);
                } else {
                    $asset = asset('dashboard/img/user-bg.png');
                }
                return '<img src="'. $asset .'" style="width: 80px">';
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->editColumn('is_frontend', function($row) {
    $checked = $row->is_frontend == 1 ? 'checked' : '';
    $url = route('user.category.status', $row->id);

    $html = '<label class="custom-switch">
                <input type="checkbox" class="status-toggle" data-id="'. $row->id .'" data-url="'. $url .'" '.$checked.'>
                <span class="slider"></span>
            </label>';

    return $html;
})





            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all']) ? '<a href="javascript::void(0)" class="btn btn-sm mx-1 btn-info editCategory" data-id="'. $row->id .'" ><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger deleteCategory" data-id="'. $row->id .'"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'icon', 'banner', 'banner2', 'is_frontend']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->where('is_deleted', 0)->newQuery();
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
            Column::make('name')->addClass('text-center')->title(__('messages.name')),
            Column::make('slug')->addClass('text-center')->title(__('messages.slug')),
            Column::make('icon')->addClass('text-center')->title(__('messages.icon')),
            Column::make('is_frontend')->addClass('text-center')->title(__('messages.show') . ' ' . __('messages.frontend')),
            Column::make('banner')->addClass('text-center')->title(__('messages.banner'))->visible(false),
            Column::make('banner2')->addClass('text-center')->title(__('messages.banner'))->visible(false),
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
        return 'Category_' . date('YmdHis');
    }
}