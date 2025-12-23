<?php

namespace App\DataTables;

use App\Helpers\Traits\CartonTrait;
use App\Helpers\Traits\RowIndex;
use App\Helpers\Traits\StockTrait;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockDataTable extends DataTable
{
    use RowIndex, CartonTrait, StockTrait;
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
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    return date('d M Y', strtotime($dates[0])) . ' - ' . date('d M Y', strtotime($dates[1]));
                }
                return date('d M Y', strtotime($row->created_at));
            })
            ->addColumn('product_details', function ($row) {
                $productName = $row->name;
                $buyingPrice = $row->buying_price;
                $sellingPrice = $row->selling_price;
                $carton = $row->carton;
                return '
                    ' . $productName . '<br>
                    Buy Price: ' . $buyingPrice . ' | Sell Price: ' . $sellingPrice . ' <br> Carton: ' . $carton . '
                ';
            })
            ->editColumn('buy', function ($row) {
                // return$row->purchases;
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    return $this->buyQuantity($row, $dates);
                } else {
                    return $row->buy_quantity ?? $this->buyQuantity($row);
                }
            })
            ->editColumn('sale', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    return $this->saleQuantity($row, $dates);
                } else {
                    return $row->sale_quantity ?? $this->saleQuantity($row);
                }
            })
            ->editColumn('return', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    return $this->returnQuantity($row, $dates);
                } else {
                    return $row->return_quantity ?? $this->returnQuantity($row);
                }
            })
            ->editColumn('prev_stock', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $date = bnToEnDate(request()->starting_date, null, 1);
                    return $this->prevStock($row->id, $date, $row->opening_stock);
                } else {
                    return 0;
                }
            })
            ->editColumn('stock', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    return $this->stock($row->id, $dates);
                } else {
                    return $row->in_stock;
                }
            })
            ->editColumn('carton', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    $stock = $this->stock($row->id, $dates);
                    return $this->carton($stock, $row->carton);
                } else {
                    $stock = $row->in_stock;
                    if ($row->stock_warning >= $stock) {
                        return '<span class="text-danger small">' . $this->carton($stock, $row->carton) . '</span>';
                    } else {
                        return $this->carton($stock, $row->carton);
                    }
                }
            })
            ->editColumn('total_buying_price', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    $total = 0;
                    $row->purchases->whereBetween('issued_date', $dates)->each(function ($purchaseItem) use (&$total) {
                        $total += $purchaseItem->buying_price * $purchaseItem->quantity;
                    });
                    return $total;
                } else {
                    $total = 0;
                    foreach ($row->prices as $price) {
                        $total += $price->quantity * $price->buying_price;
                    }
                    $diffPriceQty = $row->prices->where('buying_price', '!=', $row->buying_price)->sum('quantity');
                    $total += $row->buying_price * (($row->in_stock ?? $this->stock($row->id)) - ($diffPriceQty + $row->prices->where('buying_price', $row->buying_price)->sum('quantity')));
                    return $total;
                }
            })
            ->editColumn('total_selling_price', function ($row) {
                if (request()->starting_date && request()->ending_date) {
                    $dates = enSearchDate(request()->starting_date, request()->ending_date);
                    $total = 0;
                    $row->invoices->whereBetween('issued_date', $dates)->each(function ($invoices) use (&$total) {
                        $total += $invoices->selling_price * $invoices->quantity;
                    });
                    return $total;
                } else {
                    $total = 0;
                    foreach ($row->invoices as $price) {
                        $total += $price->quantity * $price->selling_price;
                    }
                    $diffPriceQty = $row->invoices->where('selling_price', '!=', $row->selling_price)->sum('quantity');
                    $total += $row->selling_price * (($row->in_stock ?? $this->stock($row->id)) - ($diffPriceQty + $row->invoices->where('selling_price', $row->selling_price)->sum('quantity')));
                    return $total;
                }
            })
            ->editColumn('group_id', function ($row) {
                return $row->group->name ?? '--';
            })
            ->addColumn('asset', function ($row) {
                $productBrand = $row->brand->asset ?? '---';
                $productColor = $row->color->asset ?? '---';
                $productSize = $row->size->asset ?? '---';
                return '
                    Brand:' . $productBrand . ' |
                    Size: ' . $productSize . ' |
                    Color: ' . $productColor . '
                ';
            })
            ->rawColumns(['dt_id', 'product_details', 'image', 'prev_stock', 'stock', 'carton']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        $model = $model->where('deleted_at', null)->latest()->newQuery();
        if (request()->search_text) {
            $searchText = request()->search_text;
            $model->where('deleted_at', null)
                ->where('name', 'like', '%' . $searchText . '%')
                ->orWhere('description', 'like', '%' . $searchText . '%')
                ->orWhere('buying_price', 'like', '%' . $searchText . '%')
                ->orWhere('selling_price', 'like', '%' . $searchText . '%');
        }
        if (request()->group_id) {
            $model->where('group_id', request()->group_id);
        }
        if (request()->product_id) {
            $model->where('id', request()->product_id);
        }
        if (request()->filled('product_name')) {
            $model->whereHas('product', function ($query) {
                $query->where('name', request()->product_name);
            });
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
            Column::make('product_details')->addClass('text-center')->title(__('messages.product') . ' ' . __('messages.details')),
            Column::make('group_id')->addClass('text-center')->title(__('messages.group')),
            Column::make('opening_stock')->addClass('text-center')->title(__('messages.opening_stock')),
            Column::make('buy')->addClass('text-center')->title(__('messages.buy') . ' ' . __('messages.quantity'))->searchable(false),
            Column::make('sale')->addClass('text-center')->title(__('messages.sale') . ' ' . __('messages.quantity'))->searchable(false),
            Column::make('stock')->addClass('text-center')->title(__('messages.stock'))->searchable(false),
            Column::make('carton')->addClass('text-center')->title(__('messages.carton')),
            Column::make('total_buying_price')->addClass('text-center')->title(__('messages.total') . ' ' . __('messages.buying') . ' ' . __('messages.price'))->searchable(false),
            // Column::make('total_selling_price')->addClass('text-center')->title(__('messages.total') . ' ' . __('messages.selling') . ' ' . __('messages.price'))->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Stock_' . date('YmdHis');
    }
}
