<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DepositDataTable extends DataTable
{
    use RowIndex;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if (request()->has('category_id') && !empty(request()->input('category_id'))) {
            $query->where('category_id', request()->category_id);
        }

        return (new EloquentDataTable($query))
            ->addColumn('dt_id', function ($row) {
                return $this->dt_index($row);
            })
            ->editColumn('created_at', function ($row) {
                return bnDateFormat($row->date);
            })
            ->addColumn('initial_balance', function ($row) {
                if ($row->transaction_type == 'account') {
                    return $row->amount;
                } else {
                    return 0;
                }
            })
            ->addColumn('amount', function ($row) {
                if ($row->transaction_type == 'account') {
                    return 0;
                } else {
                    return $row->amount;
                }
            })
            ->editColumn('client_id', function ($row) {
                if ($row->transaction_type == 'account') {
                    return 'Account Initial';
                } else {

                    $clientName = $row->client->client_name ?? '---';
                    $clientNumber1 = $row->client->phone ?? '---';
                    return '
                        Name: ' . $clientName . ' <span class="text-primary">|</span>
                        Number: ' . $clientNumber1 . '
                    ';
                }
            })
            ->editColumn('transaction_type', function ($row) {
                if ($row->transaction_type == 'deposit') {
                    return '<span>' . __('messages.collection') . '</span>';
                }
                if ($row->transaction_type == 'invoice') {
                    return '<a title="Goto Invoice" href="' . route('user.invoice.show', $row->invoice_id) . '"><span>' . __('messages.invoice') . '</span></a>';
                }
                if ($row->transaction_type == 'transfer') {
                    return '<span>' . __('messages.transfer') . '</span>';
                }
                if ($row->transaction_type == 'account') {
                    return '<span>' . __('messages.account') . '</span>';
                }
            })
            ->editColumn('invoice_id', function ($row) {
                return $row->invoice_id ?? '---';
            })
            ->editColumn('category_id', function ($row) {
                return $row->receiveCategory->name ?? '---';
            })
            ->rawColumns(['dt_id', 'client_id', 'description', 'transaction_type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $model = $model->with('receiveCategory')->where('type', 'deposit')->whereNot('transaction_type', 'transfer')->latest()->newQuery();
        if (request()->client_id) {
            $model->with('receiveCategory')->where('client_id', request()->client_id);
        }
        if (request()->starting_date && request()->ending_date) {
            $model->with('receiveCategory')->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
        }
        if (request()->category_id) {
            $model->with('receiveCategory')->where('category_id', request()->category_id);
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
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('date')->title('Date')->addClass('bg-white text-center')->orderable(false)->title(__('messages.date')),
            Column::make('id')->title('Voucher No')->addClass('text-center')->orderable(false)->title(__('messages.id_no')),
            Column::make('client_id')->title('Client')->addClass('text-start ps-3')->orderable(false)->title(__('messages.client')),
            Column::make('invoice_id')->title('Invoice ID')->addClass('text-center')->orderable(false)->title(__('messages.invoice') . ' ' . __('messages.id_no')),
            Column::make('description')->title('Description')->addClass('text-center')->orderable(false)->title(__('messages.description')),
            Column::make('amount')->title('Amount')->addClass('text-center')->orderable(false)->title(__('messages.amount')),
            Column::make('category_id')->title('category_id')->addClass('text-center')->orderable(false)->title(__('messages.category')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Deposit_' . date('YmdHis');
    }
}
