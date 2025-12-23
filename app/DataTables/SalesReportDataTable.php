<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Helpers\Traits\InvoiceTrait;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\SalesReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;


class SalesReportDataTable extends DataTable
{
    use RowIndex, InvoiceTrait;
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
            ->editColumn('issued_date', function ($row) {
                return date('d M Y', strtotime($row->created_at)) ?? '--';
            })
            ->editColumn('client_id', function ($row) {
                return $row->client->client_name ?? 'N/A';
            })
            ->addColumn('products', function ($row) {
                $productNames = [];

                foreach ($row->invoiceItems as $item) {
                    $productNames[] = $item->product->name ?? 'N/A';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $productNames);
            })
            ->addColumn('unit_id', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->unit->name ?? 'N/A';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('free', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->free ?? '0';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('sales', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->quantity - ($item->free + $item->return_qty) ?? '0';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('product_qty', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->quantity ?? '0';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('product_return_qty', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->return_qty ?? '0';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('product_sale_price', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = $item->selling_price ?? '0';
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('product_price', function ($row) {
                $total = 0;
                foreach ($row->invoiceItems as $item) {
                    $total += $item->selling_price;
                }
                return number_format($total, 2);
            })
            ->addColumn('product_total_amount', function ($row) {
                $unitIds = [];

                foreach ($row->invoiceItems as $item) {
                    $unitIds[] = number_format($item->selling_price * $item->quantity - ($item->free + $item->return_qty), 2);
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('total', function ($row) {
                foreach ($row->invoiceItems as $item) {
                    return $item->total;
                }
            })
            ->addColumn('return_quantity', function ($row) {
                return 0;
            })
            ->addColumn('total_free_quantity', function ($row) {
                return $row->invoiceItems->sum('free');
            })
            ->addColumn('total_return_quantity', function ($row) {
                return $row->invoiceItems->sum('return_qty');
            })
            ->addColumn('discount', function ($row) {
                return $this->discount($row->id);
            })
            ->addColumn('vat', function ($row) {
                return $this->vat($row->id);
            })
            ->addColumn('total_sales_quantity', function ($row) {
                $total = 0;
                foreach ($row->invoiceItems as $item) {
                    $total += $item->quantity - ($item->free + $item->return_qty);
                }

                return $total;
            })

            ->addColumn('quantity', function ($row) {
                return $row->invoiceItems->sum('quantity');
            })
            ->addColumn('grand_total', function ($row) {
                return number_format($this->totalBill($row->id), 2);
            })
            ->addColumn('receive_amount', function ($row) {
                return number_format($this->invoicePayment($row->id), 2);
            })
            ->addColumn('due_amount', function ($row) {
                return number_format($this->invoiceDue($row->id), 2);
            })
            ->rawColumns(['sl', 'products', 'product_qty', 'total', 'free', 'sales', 'unit_id', 'total_free_quantity', 'total_sales_quantity', 'total_return_quantity', 'product_sale_price', 'product_return_qty', 'product_total_amount', 'vat', 'discount', 'grand_total', 'receive_amount', 'due_amount']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Invoice $model): QueryBuilder
    {
        if (request()->queryString == 'daily') {
            return $model->with('invoiceItems')->whereDate('created_at', Carbon::today())->newQuery();
        } else if (request()->client_id !== null) {
            $startDate = date('Y-m-d H:i:s', strtotime(request()->starting_date));
            $endDate = date('Y-m-d H:i:s', strtotime(request()->ending_date));
            return $model->with('invoiceItems')->whereBetween('created_at', [$startDate, $endDate])->where('client_id', request()->client_id)->newQuery();
        } else if (request()->group_id !== null) {
            $startDate = date('Y-m-d H:i:s', strtotime(request()->starting_date));
            $endDate = date('Y-m-d H:i:s', strtotime(request()->ending_date));

            $query = $model->with(['invoiceItems', 'client'])->whereBetween('created_at', [$startDate, $endDate]);
            return $query->whereHas('client', function ($q) {
                $q->where('group_id', request()->group_id);
            });
        } else {
            return $model->with('invoiceItems')->newQuery();
        }
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
            Column::make('dt_id')->title(__('messages.sl')),
            Column::make('issued_date')->orderable(false)->addClass('text-center')->title(__('messages.issued_date')),
            Column::make('id')->orderable(false)->addClass('text-center')->title(__('messages.id')),
            Column::make('client_id')->orderable(false)->addClass('text-center')->title(__('messages.client')),
            Column::make('products')->orderable(false)->addClass('pe-0 border-end-0')->width('200px')->title(__('messages.product')),
            Column::make('unit_id')->orderable(false)->addClass('ps-0 border-start-0')->width('50px')->title(__('messages.unit')),
            Column::make('quantity')->orderable(false)->addClass('text-center')->title(__('messages.quantity')),
            Column::make('product_price')->orderable(false)->addClass('text-center')->title(__('messages.price')),
            Column::make('total')->orderable(false)->addClass('text-center')->title(__('messages.total')),
            Column::make('discount')->orderable(false)->addClass('text-center')->title(__('messages.discount')),
            Column::make('transport_fare')->orderable(false)->addClass('text-center')->title(__('messages.transport_fare')),
            Column::make('return_quantity')->orderable(false)->addClass('text-center')->title(__('messages.return_quantity')),
            Column::make('grand_total')->orderable(false)->addClass('text-center')->title(__('messages.grand_total')),

            Column::make('receive_amount')->orderable(false)->addClass('text-center')->title(__('messages.receive') . ' ' . __('messages.amount')),
            Column::make('due_amount')->orderable(false)->addClass('text-center')->title(__('messages.due') . ' ' . __('messages.amount')),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SalesReport_' . date('YmdHis');
    }
}
