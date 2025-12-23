<?php

namespace App\DataTables;

use App\Helpers\Traits\AccountBalanceTrait;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\Traits\InvoiceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Invoice;
use App\Models\SalesReturn;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SalesReturnDataTable extends DataTable
{
    use DeleteLogTrait, AccountBalanceTrait, InvoiceTrait, RowIndex;
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
            ->editColumn('client_id', function ($row) {
                if ($row->transaction_type == 'account') {
                    return 'Account Initial';
                } else {

                    $clientName = $row->client->client_name ?? '---';
                    $clientNumber1 = $row->client->phone ?? '---';
                    return '
                    Name: ' . $clientName . ' <br>
                    Number: ' . $clientNumber1 . ' <br>
                    ';
                }
            })
            ->editColumn('discount', function ($row) {
                return $row->discount ?? '0.00';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 5) {
                    return '<span class="px-1 rounded bg-warning">Draft</span>';
                } else if ($row->status == 4) {
                    return '<span class="px-1 rounded bg-warning">Return</span>';
                } else {
                    return '<span class="px-1 rounded bg-success">General</span>';
                }
            })
            ->editColumn('invoice_id', function ($row) {
                $invoice_id = 'Invoice ID: ' . $row->id;
                $status = $row->status == 5 ? "| <span class='text-warning'>Draft</span>" : '';
                return $invoice_id . ' ' . $status;
            })
            ->editColumn('account_id', function ($row) {
                return $row->account->title ?? '--';
            })
            ->editColumn('category_id', function ($row) {
                $category = $row->category->name ?? '--';
                return $category;
            })
            ->addColumn('action', function ($row) {
                return view('user.invoice.includes.action', compact('row'));
            })
            ->addColumn('printable', function ($row) {
                return view('user.invoice.includes.print-buttons', compact('row'));
            })
            ->rawColumns(['action', 'dt_id', 'client_id', 'printable', 'description', 'invoice_id', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Invoice $model): QueryBuilder
    {
        $model = $model->where('status', 4)->whereNotNull('total_return')->whereNull('deleted_at')->latest()->newQuery();
        if (request()->account_id) {
            $model->where('account_id', request()->account_id);
        }
        if (request()->client_id) {
            $model->where('client_id', request()->client_id);
        }
        if (request()->invoice_id) {
            $model->where('id', request()->invoice_id);
        }
        if (request()->starting_date && request()->ending_date) {
            $model->whereBetween('issued_date', [enSearchDate(request()->starting_date, request()->ending_date)]);
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
        return [
            Column::make('dt_id')->addClass('text-center')->title(__('messages.sl')),
            Column::make('client_id')->addClass('text-center')->title(__('messages.client')),
            Column::make('discount')->addClass('text-center')->title(__('messages.discount')),
            Column::make('account_id')->addClass('text-center')->title(__('messages.account')),
            Column::make('category_id')->addClass('text-center')->title(__('messages.category')),
            Column::make('return_quantity')->addClass('text-center')->title(__('messages.return ') . ' ' . __('messages.quantity')),
            Column::make('bill_amount')->addClass('text-center')->title(__('messages.bill') . ' ' . __('messages.amount')),
            Column::make('receive_amount')->addClass('text-center')->title(__('messages.receive') . ' ' . __('messages.amount')),
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
        return 'SalesReturn_' . date('YmdHis');
    }
}
