<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Helpers\Traits\InvoiceTrait;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\SalesReport;
use App\Models\Transaction;
use App\Models\User;
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


class SalesReportTransactionWiseDataTable extends DataTable
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
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('issued_date', function ($row) {
                return bnDateFormat($row->date);
            })
            ->editColumn('client_id', function ($row) {
                return $row->client->client_name ?? 'N/A';
            })
            ->editColumn('invoice_id', function ($row) {
                return $row->invoice->id ?? '--';
            })
            ->addColumn('products', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return "Deposit";
                } else {
                    $productNames = [];
                    foreach ($row->invoice->invoiceItems ?? [] as $item) {
                        $productId = $item->product->id ?? 0;
                        if (request()->product_id != null) {
                            if (request()->product_id == $productId) {
                                $productNames[] = $item->product->name ?? 'N/A';
                            }
                        } else if (request()->product_group_id != null) {
                            $productGroupId = $item->product->group->id ?? 0;
                            if (request()->product_group_id == $productGroupId) {
                                $productNames[] = $item->product->name ?? 'N/A';
                            }
                        } else {
                            $productNames[] = $item->product->name ?? 'N/A';
                        }
                    }
                    return implode('<br><hr class="m-0 bg-danger"> ', $productNames);
                }
            })
            ->addColumn('unit_id', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $unitIds = [];
                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $unitIds[] = $item->unit->name ?? 'N/A';
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $unitIds[] = $item->unit->name ?? 'N/A';
                        }
                    } else {
                        $unitIds[] = $item->unit->name ?? 'N/A';
                    }
                }
                return implode('<br><hr class="m-0 bg-danger"> ', $unitIds);
            })
            ->addColumn('product_qty', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $quantities = [];

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $quantities[] = $item->quantity ?? '0';
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $quantities[] = $item->quantity ?? '0';
                        }
                    } else {
                        $quantities[] = $item->quantity ?? '0';
                    }
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $quantities);
            })
            ->addColumn('product_return_qty', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $quantities = [];

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $quantities[] = $item->return_qty ?? '0';
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $quantities[] = $item->return_qty ?? '0';
                        }
                    } else {
                        $quantities[] = $item->return_qty ?? '0';
                    }
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $quantities);
            })
            ->addColumn('product_sale_price', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $salePrices = [];

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $salePrices[] = $item->selling_price ?? '0';
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $salePrices[] = $item->selling_price ?? '0';
                        }
                    } else {
                        $salePrices[] = $item->selling_price ?? '0';
                    }
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $salePrices);
            })
            ->addColumn('product_price', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $price = [];

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $price[] = $item->selling_price * $item->quantity;
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $price[] = $item->selling_price * $item->quantity;
                        }
                    } else {
                        $price[] = $item->selling_price * $item->quantity;
                    }
                }

                return implode('<br><hr class="m-0 bg-danger"> ', $price);
            })
            ->addColumn('product_total_amount', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $productTotalAmount = [];
                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $productTotalAmount[] = number_format($item->selling_price * $item->quantity - ($item->free + $item->return_qty), 2);
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $productTotalAmount[] = number_format($item->selling_price * $item->quantity - ($item->free + $item->return_qty), 2);
                        }
                    } else {
                        $productTotalAmount[] = number_format($item->selling_price * $item->quantity - ($item->free + $item->return_qty), 2);
                    }
                }
                return implode('<br><hr class="m-0 bg-danger"> ', $productTotalAmount);
            })
            ->addColumn('total', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $total = 0;

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;
                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $total += $item->selling_price * $item->quantity;
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $total += $item->selling_price * $item->quantity;
                        }
                    } else {
                        $total += $item->selling_price * $item->quantity;
                    }
                }

                return $total;
            })
            ->addColumn('discount', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                return $this->discount($row->invoice_id ?? 0);
            })
            ->addColumn('transport_fare', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $transport_fare = $row->invoice->transport_fare ?? 0;
                return number_format($transport_fare);
            })
            ->addColumn('vat', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $vat = $row->invoice->vat ?? 0;
                return number_format($vat);
            })
            ->addColumn('return_quantity', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $returnQuantity = 0;
                if ($row->transaction_type == 'invoice-return') {
                    foreach ($row->invoice->invoiceItems ?? [] as $item) {
                        $productId = $item->product->id ?? 0;
                        if (request()->product_id != null) {
                            if (request()->product_id == $productId) {
                                $returnQuantity += $item->quantity;
                            }
                        } else if (request()->product_group_id != null) {
                            $productGroupId = $item->product->group->id ?? 0;
                            if (request()->product_group_id == $productGroupId) {
                                $returnQuantity += $item->quantity;
                            }
                        } else {
                            $returnQuantity += $item->quantity;
                        }
                    }
                    return $returnQuantity;
                } else {
                    foreach ($row->invoice->invoiceItems ?? [] as $item) {
                        $productId = $item->product->id ?? 0;
                        if (request()->product_id != null) {
                            if (request()->product_id == $productId) {
                                $returnQuantity += $item->return_quantity;
                            }
                        } else if (request()->product_group_id != null) {
                            $productGroupId = $item->product->group->id ?? 0;
                            if (request()->product_group_id == $productGroupId) {
                                $returnQuantity += $item->return_quantity;
                            }
                        } else {
                            $returnQuantity += $item->return_quantity;
                        }
                    }
                    return $returnQuantity;
                }
            })

            ->addColumn('quantity', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $quantity = [];
                $quantityCount = 0;

                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product->id ?? 0;

                    if (request()->product_id != null) {
                        if (request()->product_id == $productId) {
                            $quantityCount += $item->quantity ?? 0;
                        }
                    } else if (request()->product_group_id != null) {
                        $productGroupId = $item->product->group->id ?? 0;
                        if (request()->product_group_id == $productGroupId) {
                            $quantity[] = $item->quantity ?? 0;
                        }
                    } else {
                        $quantity[] = $item->quantity ?? 0;
                    }
                }

                // Place return statements outside the loop
                if (request()->product_id != null) {
                    return $quantityCount;
                } else {
                    return implode('<br><hr class="m-0 bg-danger"> ', $quantity);
                }
            })
            ->addColumn('grand_total', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                if ($row->invoice_id !== null && $row->transaction_type == 'invoice') {
                    return $row->invoice->grand_total ?? 0;
                } else {
                }
            })
            ->addColumn('receive_amount', function ($row) {
                if ($row->invoice_id !== null && $row->transaction_type == 'invoice') {
                    return $row->invoice->receive_amount ?? 0;
                } else {
                    return $row->amount;
                }
            })
            ->addColumn('due_amount', function ($row) use (&$previousDue) {
                if ($row->transaction_type == 'deposit') {
                    return $previousDue -= $row->amount;
                }
                if ($row->invoice_id !== null && $row->transaction_type == 'invoice') {
                    $grand = $row->invoice->grand_total ?? 0;
                    $receive = $row->invoice->receive_amount ?? 0;
                    $dueAmount = $grand + $previousDue - $receive;
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                }
                if ($row->invoice_id === null) {
                    $dueAmount = $previousDue - $row->amount;
                    $previousDue = $dueAmount; // Update the cumulative due amount
                    return $dueAmount;
                }
                $previousDue += $row->amount; // Update cumulative due amount for non-invoice transactions
                return $previousDue;
            })
            ->addColumn('profit', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return 0;
                }
                $buyingPrice = 0;
                $sellingPrice = 0;
                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $productId = $item->product_id ?? 0;
                    if (request()->product_id != null && request()->product_id == $productId) {
                        $buyingPrice += $item->buying_price * $item->quantity;
                        $sellingPrice += $item->selling_price * $item->quantity;
                    } else {
                        $buyingPrice += $item->buying_price * $item->quantity;
                        $sellingPrice += $item->selling_price * $item->quantity;
                    }
                }

                $profit = $sellingPrice - $buyingPrice - ($row->invoice->discount ?? 0);
                return str_replace(',', '', number_format($profit, 2));
            })
            ->rawColumns(['sl', 'products', 'product_qty', 'total', 'product_price', 'sales', 'unit_id', 'total_free_quantity', 'total_sales_quantity', 'total_return_quantity', 'product_sale_price', 'product_return_qty', 'product_total_amount', 'vat', 'discount', 'grand_total', 'receive_amount', 'due_amount', 'quantity']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $model = $model->newQuery()->with(['invoice', 'client'])->whereIn('transaction_type', ['invoice', 'deposit'])->where('deleted_at', null);
        $model->whereHas('invoice', function ($query) {
            $query->where('status', 0);
        });
        if (request()->queryString == 'daily-search') {
            $model->whereDate('date', Carbon::today());
        }
        if (request()->client_id !== null) {
            $startDate = bnToEnDate(request()->starting_date)->format('Y-m-d');
            $endDate = bnToEnDate(request()->ending_date)->addDay()->format('Y-m-d');
            $model->whereBetween('date', [$startDate, $endDate])->where('client_id', request()->client_id);
        }
        if (request()->client_group_id !== null) {
            $startDate = bnToEnDate(request()->d_starting_date)->startOfDay();
            $endDate = bnToEnDate(request()->d_ending_date)->endOfDay();
            $query = $model->whereBetween('date', [$startDate, $endDate]);
            return $query->whereHas('client', function ($q) {
                $q->where('group_id', request()->client_group_id);
            });
        }
        if (request()->product_group_id !== null) {
            $startDate = bnToEnDate(request()->d_starting_date)->startOfDay();
            $endDate = bnToEnDate(request()->d_ending_date)->endOfDay();
            $query = $model->whereHas('invoice.invoiceItems.product', function ($product) {
                $product->where('group_id', request()->product_group_id);
            })->whereBetween('date', [$startDate, $endDate]);
        }

        if (request()->filled('select_client_id')) {
            $model->where('client_id', request()->select_client_id);
        }

        if (request()->filled('staff_id')) {
            $user = User::findOrFail(request()->staff_id);
            $model->where('created_by', $user->username);
        }

        if (request()->filled('invoice_id')) {
            $model->where('invoice_id', request()->invoice_id);
        }

        if (request()->filled('starting_date') && request()->filled('ending_date')) {
            $startDate = bnToEnDate(request()->starting_date)->startOfDay();
            $endDate = bnToEnDate(request()->ending_date)->endOfDay();
            $model->whereBetween('date', [$startDate, $endDate]);
        }
        if (request()->filled('product_id')) {
            $model->whereHas('invoice', function ($query) {
                $query->whereHas('invoiceItems', function ($queryItems) {
                    $queryItems->where('product_id', request()->product_id);
                });
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
