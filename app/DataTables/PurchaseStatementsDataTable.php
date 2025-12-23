<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseReport;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PurchaseStatementsDataTable extends DataTable
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
            ->editColumn('date', function ($row) {
                return bnDateFormat($row->date);
            })
            ->editColumn('product_id', function ($row) {
                return $row->product->name ?? '---';
            })
            ->editColumn('client_id', function ($row) {
                return $row->client->client_name ?? 'N/A';
            })
            ->addColumn('product', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    $productNames = [];
                    foreach ($row->purchase->purchaseItems ?? [] as $item) {
                        if ($row->transaction_type == 'purchase_return') {
                            $productNames[] = ($item->product->name ?? 'N/A') . ' (' . __('messages.return') . ')';
                        } else {
                            $productNames[] = $item->product->name ?? 'N/A';
                        }
                    }
                    return implode('<br><hr class="m-0 bg-danger"> ', $productNames);
                }
                if ($row->transaction_type == 'previous_due') {
                    return __('messages.previous_due');
                }
                if ($row->transaction_type == 'supplier_payment') {
                    return __('messages.payment');
                }
                if ($row->transaction_type == 'supplier_receive') {
                    return __('messages.receive');
                }
            })
            ->addColumn('unit_id', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    $unitIds = [];
                    foreach ($row->purchase->purchaseItems ?? [] as $item) {
                        $unitIds[] = $item->unit->name ?? 'N/A';
                    }
                    return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                }
            })
            ->addColumn('quantity', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    $unitIds = [];
                    foreach ($row->purchase->purchaseItems ?? [] as $item) {
                        $unitIds[] = $item->quantity ?? '0';
                    }

                    return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
                }
            })
            ->addColumn('price', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    $price = [];
                    foreach ($row->purchase->purchaseItems ?? [] as $item) {
                        $price[] = $item->buying_price ?? '0';
                    }
                    return implode('<br><hr class="m-0 bg-danger"> ', $price);
                }
            })
            ->addColumn('buying_price', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    $buyingPrice = [];
                    foreach ($row->purchase->purchaseItems ?? [] as $item) {
                        $buyingPrice[] = $item->total_buying_price;
                    }
                    return implode('<br><hr class="m-0 bg-danger"> ', $buyingPrice);
                }
            })
            // ->addColumn('selling_price', function ($row) {
            //     if ($row->transaction_type == 'purchase') {
            //         $sellingPrice = [];
            //         foreach ($row->purchase->purchaseItems ?? [] as $item) {
            //             $sellingPrice[] = $item->total_selling_price;
            //         }

            //         return implode('<br><hr class="m-0 bg-danger"> ', $sellingPrice);
            //     }
            // })
            ->addColumn('discount', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return') {
                    return $row->purchase->total_discount ?? 0;
                }
            })
            ->addColumn('grand_total', function ($row) {
                if ($row->transaction_type == 'previous_due') {
                    return $row->amount;
                } else if ($row->transaction_type == 'purchase') {
                    return $row->purchase->grand_total ?? 0;
                } else if ($row->transaction_type == 'purchase_return') {
                    $grandTotal = $row->purchase->grand_total ?? 0;
                    return -$grandTotal;
                }
            })
            ->addColumn('payment_amount', function ($row) {
                if ($row->transaction_type == 'supplier_payment') {
                    return $row->amount;
                } else if ($row->transaction_type == 'previous_due') {
                    return 0;
                } else if ($row->transaction_type == 'supplier_receive') {
                    return "0.00";
                } else if ($row->transaction_type == 'purchase') {
                    return $row->purchase->receive_amount;
                } else {
                    return $row->amount;
                }
            })
            ->addColumn('receive_amount', function ($row) {
                if ($row->transaction_type == 'supplier_receive') {
                    return $row->amount;
                } else {
                    return "0.00";
                }
            })
            ->addColumn('due_amount', function ($row) use (&$previousDue) {
                if ($row->purchase_id !== null && ($row->transaction_type == 'purchase' || $row->transaction_type == 'purchase_return')) {
                    $grand = $row->purchase->grand_total ?? 0;
                    $receive = $row->purchase->receive_amount ?? 0;
                    if ($row->transaction_type == 'purchase_return') {
                        $dueAmount = $previousDue - $grand;
                    } else {
                        $dueAmount = $grand - $receive + $previousDue;
                    }
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                } else if ($row->transaction_type == 'supplier_receive') {
                    $receive = $row->amount;
                    $dueAmount = $previousDue + $receive;
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                } else if ($row->transaction_type == 'previous_due') {
                    $previousDue = $row->amount;
                    return $previousDue;
                } else if ($row->purchase_id == null) {
                    $receive = $row->purchase->receive_amount ?? 0;
                    $dueAmount = $previousDue - $row->amount;
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                } else if ($row->purchase_id == !null) {
                    $receive = $row->purchase->receive_amount ?? 0;
                    $dueAmount = $previousDue - $row->amount;
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                } else {
                    if ($row->type == 'cost') {
                        return 0; // or any default value for deposits
                    } else {
                        $previousDue += $row->amount; // Update cumulative due amount for non-invoice transactions
                        return $previousDue;
                    }
                }
            })
            ->editColumn('supplier_id', function ($row) {
                return $row->purchase->supplier->supplier_name ?? '---';
            })
            ->rawColumns(['action', 'dt_id', 'supplier_id', 'product', 'unit_id', 'quantity', 'buying_price', 'selling_price', 'price', 'total', 'discount', 'grand_total', 'receive_amount', 'due_amount']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $model = $model->where('deleted_at', null)->where('supplier_id', '!=', null)->whereIn('transaction_type', ['purchase', 'purchase_return', 'supplier_payment', 'previous_due', 'supplier_receive'])->with(['purchase', 'supplier'])->orderBy('date', 'asc')->newQuery();
        if (request()->supplier_id) {
            $model->where('supplier_id', request()->supplier_id);
        }
        if (request()->starting_date && request()->ending_date) {
            $model->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
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
            ->addTableClass('table table-bordered table-striped table-hover text-center')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(1)
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
            Column::make('dt_id')->orderable(true)->title(__('messages.id_no')),
            Column::make('created_at')->title(__('messages.date'))->addClass('bg-white date-cell')->orderable(false),
            // Column::make('supplier_id')->title(__('messages.supplier'))->searchable(false)->orderable(false),
            Column::make('product')->title(__('messages.product')),
            Column::make('unit_id')->title(__('messages.unit')),
            Column::make('quantity')->title(__('messages.qty')),
            Column::make('price')->title(__('messages.price')),
            Column::make('buying_price')->title(__('messages.total') . ' ' . __('messages.buying')),
            // Column::make('selling_price')->title(__('messages.total') . ' ' . __('messages.selling')),
            Column::make('discount')->title(__('messages.dis')),
            Column::make('grand_total')->title(__('messages.grand_total')),
            Column::make('receive_amount')->title(__('messages.payment')),
            Column::make('due_amount')->title(__('messages.due')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PurchaseReport_' . date('YmdHis');
    }
}
