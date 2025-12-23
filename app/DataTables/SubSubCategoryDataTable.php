<?php

namespace App\DataTables;

use App\Models\SubSubCategory;
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

class SubSubCategoryDataTable extends DataTable
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
            ->addColumn('category', function($row){
                return $row->cat->name ?? 'N/A';
            })
            ->addColumn('subcategory', function($row){
                return $row->subcat->name ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all']) ? '<a href="javascript::void(0)" onclick="editSubSubCategory('. $row->id .')" class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </div> 
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'icon', 'banner', 'banner2']);
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(SubSubCategory $model): QueryBuilder
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
            Column::make('category')->addClass('text-center')->title(__('messages.category')),
            Column::make('subcategory')->addClass('text-center')->title(__('messages.subcategory')),
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
        return 'SubSubCategory_' . date('YmdHis');
    }
}
