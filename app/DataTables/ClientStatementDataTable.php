<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Client;
use App\Models\ClientStatement;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientStatementDataTable extends DataTable
{
    use RowIndex;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if (request()->client_id) {
            $client = Client::findOrFail(request()->client_id);
            $previousDue = $client->previous_due;

            // Create a new AccountTransaction record for the previous due
            $clientData = new Transaction([
                'description' => "Previous due",
                'date' => $client->created_at,
                'type' => 'previous_due',
                'invoice_type' => 'previous_due',
                'amount' => $previousDue,
                'balance' => $previousDue, // Initialize balance with previous due amount
                'client_id' => $client->id,
                'account_id' => 0,
                'created_by' => Auth::user()->created_by,
            ]);

            // Retrieve the data including the newly created record
            $data = Transaction::where('type', 'deposit')
                ->where('client_id', $client->id)
                ->where('created_by', Auth::user()->created_by)
                ->get();

            // Add the clientData to the collection
            $data->prepend($clientData);

            // Update the balance based on the previous due
            $balance = $previousDue;
        } else {
            $data = Transaction::where('type', 'deposit')
                ->whereNotNull('client_id')
                ->where('created_by', Auth::user()->created_by)
                ->get();
        }
        return (new EloquentDataTable($query))
            ->addColumn('dt_id', function ($row) {
                return $this->dt_index($row);
            })
            ->addColumn('purchase_bill', function ($row) {
                return ($row->invoice_type == "manual_ticket") ? $row->manualInvoice->grand_total ?? 0 : '0.00';
            })
            ->addColumn('payment_or_debit', function ($row) {
                return ($row->invoice_type == "select") ? $row->amount ?? 0 : '0.00';
            })
            ->addColumn('balance', function ($row) use (&$balance) {
                $purchaseBill = ($row->invoice_type == "manual_ticket") ? ($row->manualInvoice->grand_total ?? 0) : 0;
                $paymentOrDebit = ($row->invoice_type == "select") ? ($row->amount ?? 0) : 0;
                $balance += $purchaseBill - $paymentOrDebit;
                return $balance;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->rawColumns(['purchase_bill', 'payment_or_debit', 'balance', 'description', 'dt_id']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->whereNotNull('client_id')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clientstatement-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('lBfrtip')
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.action')),
            Column::make('id')->title(__('messages.id_no')),
            Column::make('add your columns'),
            Column::make('created_at')->title(__('messages.created_at')),
            Column::make('updated_at')->title(__('messages.updated_at')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ClientStatement_' . date('YmdHis');
    }
}
