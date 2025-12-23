<?php

namespace App\DataTables;

use App\Helpers\Traits\StockTrait;
use App\Models\Product;
use App\Models\StockWarningProduct;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StockWarningProductsDataTable extends DataTable
{
    use StockTrait;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('group_id', function ($row) {
                return $row->group->name ?? '--';
            })
            ->addColumn('brand_id', function ($row) {
                return $row->brand->asset ?? '--';
            })
            ->addColumn('unit_id', function ($row) {
                return $row->unit->name ?? '--';
            })
            ->addColumn('stock', function ($row) {
                return $row->stockCount($row->id);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        // Start a new query on the Product model
        $query = $model->newQuery();

        // Get all products and filter by stock dynamically
        $products = $query->get();

        // Filter products with stock_warning greater than or equal to their stock
        $filteredProducts = $products->filter(function ($product) {
            return $product->stock_warning >= $this->stock($product->id);
        });

        // If you need to return a query builder, consider creating a new query with filtered IDs
        $filteredIds = $filteredProducts->pluck('id');
        return $model->newQuery()->whereIn('id', $filteredIds);
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('stockDataTable')
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'StockWarningProducts_' . date('YmdHis');
    }
}
