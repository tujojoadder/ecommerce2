<?php

namespace App\DataTables;

use App\Helpers\Traits\InvoiceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
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
                $date = bnDateFormat($row->issued_date);
                if ($row->created_at == $row->updated_at) {
                    $eidtedOrNot = '';
                } else {
                    $eidtedOrNot = __('messages.edited');
                }
                return $date . '<br>' . '<span class="badge bg-success text-white">' . $eidtedOrNot . '</span>';
            })
            ->editColumn('client_id', function ($row) {
                if ($row->transaction_type == 'account') {
                    return 'Account Initial';
                } else {

                    $clientName = $row->client_name ?? '---';
                    $clientNumber1 = $row->client_phone ?? '---';
                    return '
                        Name: ' . $clientName . ' <br>
                        Number: ' . $clientNumber1 . ' <br>
                    ';
                }
            })
            ->editColumn('bill_amount', function ($row) {
                return numberFormat($row->grand_total, 2);
            })
            ->editColumn('due_amount', function ($row) {
                return $row->invoice_due;
            })
            ->editColumn('invoice_id', function ($row) {
                $invoice_id = $row->id;
                $status = $row->status == 5 ? "| <span class='text-warning'>Draft</span>" : '';
                return $invoice_id . ' ' . $status;
            })
            ->editColumn('account_id', function ($row) {
                return $row->account_title ?? '--';
            })
            ->editColumn('total_return', function ($row) {
                return $row->total_return ?? '0';
            })
            ->editColumn('receive_amount', function ($row) {
                return $row->invoice_receive;
            })
            ->editColumn('category_id', function ($row) {
                $category = $row->category_name ?? '--';
                return $category;
            })
            ->addColumn('action', function ($row) {
                return view('user.invoice.includes.action', compact('row'));
            })
            ->addColumn('printable', function ($row) {
                return view('user.invoice.includes.print-buttons', compact('row'));
            })
            ->addColumn('challan', function ($row) {
                return '<a href="' . route('user.invoice.challan', $row->id) . '" class="btn btn-sm mx-1 mb-1 btn-success"><i class="fas fa-receipt"></i> ' . __('messages.challan') . ' ' . __('messages.view') . '</a>';
            })
            ->rawColumns(['action', 'issued_date', 'dt_id', 'client_id', 'printable', 'description', 'invoice_id', 'status', 'challan']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Invoice $model): QueryBuilder
    {
        $model = $model->whereNull('deleted_at')->orderBy('issued_date', 'desc')->newQuery();

        if (request()->draft) {
            $model->where('status', 5);
        } else {
            $model->where('status', 0);
        }
        if (request()->starting_date && request()->ending_date) {
            $model->whereBetween('issued_date', [enSearchDate(request()->starting_date, request()->ending_date)]);
        }
        if (request()->invoice_id) {
            $model->where('id', request()->invoice_id);
        }
        if (request()->account_id) {
            $model->where('account_id', request()->account_id);
        }
        if (request()->client_id) {
            $model->where('client_id', request()->client_id);
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
        $returnOrReceive = request()->routeIs('user.invoice.sales.return') ? __('messages.return') . ' ' . __('messages.quantity') : __('messages.receive') . ' ' . __('messages.amount');

        return [

            Column::make('dt_id')->addClass('text-center')->title(__('messages.sl')),

            Column::make('client_id')->addClass('text-center')->title(__('messages.client')),
            Column::make('discount')->addClass('text-center')->title(__('messages.discount')),
            Column::make('account_id')->addClass('text-center')->title(__('messages.account')),
            Column::make('category_id')->addClass('text-center')->title(__('messages.category')),
            Column::make('total_return')->addClass('text-center')->title(__('messages.return') . ' ' . __('messages.quantity')),
            Column::make('bill_amount')->addClass('text-center')->title(__('messages.bill') . ' ' . __('messages.amount')),
            Column::make('receive_amount')->addClass('text-center')->title($returnOrReceive),
            Column::make('due_amount')->addClass('text-center')->title(__('messages.due') . ' ' . __('messages.amount')),
            Column::make('created_at')->title('Date')->addClass('text-center')->title(__('messages.created_at')),
            Column::computed('printable')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')->title(__('messages.printable')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.action'))
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Invoice_' . date('YmdHis');
    }
}
