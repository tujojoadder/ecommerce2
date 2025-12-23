<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Helpers\Traits\StockTrait;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\ProductAsset;
use Illuminate\Support\Facades\Gate;

class ProductDataTable extends DataTable
{
    use RowIndex, StockTrait;
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
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->editColumn('image', function ($row) {
                if ($row->image != null) {
                    $asset = asset('storage/product/' . $row->image);
                } else {
                    $asset = asset('dashboard/img/user-bg.png');
                }
                $modal = <<<HTML
                        <!-- Modal -->
                        <div class="modal fade" id="productPicture$row->id">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">$row->name | Buying Price: $row->buying_price | Selling Price: $row->selling_price</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-2">
                                    <img class="border" src=$asset>
                                </div>
                                <div class="modal-footer py-1">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>
                HTML;
                return '<div uk-lightbox> <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#productPicture' . $row->id . '"><img class="border" src="' . $asset . '" height="30" width="30"><a> </div>' . $modal;
            })
            ->editColumn('opening_stock', function ($row) {
                return $this->stock($row->id);
            })
            ->editColumn('stock_warning', function ($row) {
                return $row->stock_warning ?? '---';
            })
            ->editColumn('barcode_number', function ($row) {
                if (config('products_custom_barcode_no') == 1) {
                    $barcode = $row->custom_barcode_no ?? $row->id;
                } else {
                    $barcode = $row->id;
                }
                return $barcode;
            })
            ->addColumn('product_details', function ($row) {
                $productName = $row->name;
                $productUnit = $row->unit_name ?? '---';
                if (config('products_new_price_sale_only') == 1) {
                    $buyingPrice = $row->last_buying_price ?? $row->buying_price;
                    $sellingPrice = $row->last_selling_price ?? $row->selling_price;
                } else {
                    $buyingPrice = $row->buying_price;
                    $sellingPrice = $row->selling_price;
                }
                $wholesalePrice = $row->wholesale_price;
                return '
                    ' . $productName . '<br>
                    Buy Price: ' . $buyingPrice . '
                    | Sell Price: ' . $sellingPrice . '
                    | Wholesall Price: ' . $wholesalePrice . '
                    | ' . __('messages.unit') . ': ' . $productUnit . '
                ';
            })
            ->addColumn('asset', function ($row) {
                $productBrand = $row->brand_name ?? null;
                $productColor = $row->color_name ?? null;
                $productSize = $row->size_name ?? null;
                if (config('sidebar.product_brand') == 1) {
                    if ($productBrand == !null) {
                        return 'Brand:' . $productBrand . ' ';
                    }
                } else {
                    return '--';
                }
                if (config('sidebar.product_color') == 1) {
                    if ($productColor == !null) {
                        return '| Color:' . $productColor . ' ';
                    }
                } else {
                    return '--';
                }
                if (config('sidebar.product_color') == 1) {
                    if ($productSize == !null) {
                        return 'Size:' . $productSize . ' ';
                    }
                } else {
                    return '--';
                }
            })
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'product-edit']) ? '<a href="'. route('user.product.edit', $row->id) .'" class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'product-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'id', 'product_details', 'image']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        $query = $model->newQuery()->latest();

        $query->when(request()->product_id, function ($query) {
            return $query->where('id', request()->product_id);
        });

        // Using when for conditional logic
        $query->when(request()->group_id, function ($query) {
            return $query->where('group_id', request()->group_id);
        });

        $query->when(request()->brand_id, function ($query) {
            return $query->where('brand_id', request()->brand_id);
        });

        $query->when(request()->starting_date && request()->ending_date, function ($query) {
            $date = enSearchDate(request()->starting_date, request()->ending_date);
            return $query->whereBetween('created_at', $date);
        });

        $query->when(request()->search_text, function ($query) {
            $searchText = request()->search_text;
            return $query->where(function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%')
                    ->orWhere('description', 'like', '%' . $searchText . '%')
                    ->orWhere('buying_price', 'like', '%' . $searchText . '%')
                    ->orWhere('selling_price', 'like', '%' . $searchText . '%')
                    ->orWhere('custom_barcode_no', 'like', '%' . $searchText . '%')
                    ->orWhere('id', 'like', '%' . $searchText . '%');
            });
        });

        return $query;
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
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
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
            Column::make('product_details')->addClass('text-center')->title(__('messages.product') . ' ' . __('messages.details')),
            Column::make('barcode_number')->addClass('text-center')->title(__('messages.barcode_number')),
            Column::make('stock_warning')->addClass('text-center')->title(__('messages.stock_warning')),
            Column::make('asset')->addClass('text-center')->title(__('messages.asset')),
            Column::make('image')->addClass('text-center')->title(__('messages.image')),
            Column::make('opening_stock')->addClass('text-center')->title(__('messages.opening_stock')),
            // Column::make('created_at')->title(__('messages.created_at')),
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
        return 'Product_' . date('YmdHis');
    }
}
