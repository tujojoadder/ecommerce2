<?php

namespace App\DataTables;

use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Client;
use App\Models\DueReport;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DueReportDataTable extends DataTable
{
    use RowIndex, BalanceTrait;
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
            ->editColumn('full_name', function ($row) {
                return '<a href="' . route('user.client.view', $row->id) . '">' . $row->full_name ?? 'N/A' . '</a>';
            })
            ->editColumn('previous_due', function ($row) {
                return $row->previous_due ?? '0.00';
            })
            ->editColumn('total_sale', function ($row) {
                $client_id = $row->account->client_id ?? '';
                return $this->allWallets(Auth::user()->created_by, $client_id)['total_sale_by_client'];
            })
            ->editColumn('total_bill', function ($row) {
                $client_id = $row->account->client_id ?? '';
                $totalDeposit = $this->allWallets(Auth::user()->created_by, $client_id)['total_deposit_by_client']; // - $totalReturn;
                $totalSale = $this->allWallets(Auth::user()->created_by, $client_id)['total_sale_by_client'] + $row->previous_due; // it's due

                $totalAmount = $totalSale;
                return $totalAmount;
            })
            ->editColumn('receive', function ($row) {
                $client_id = $row->account->client_id ?? '';
                $totalReturn = $this->allWallets(Auth::user()->created_by, $client_id)['total_return_by_client'];
                $totalDeposit = $this->allWallets(Auth::user()->created_by, $client_id)['total_deposit_by_client'] - $totalReturn;
                return $totalDeposit;
            })
            ->editColumn('return', function ($row) {
                $client_id = $row->account->client_id ?? '';
                $totalReturn = $this->allWallets(Auth::user()->created_by, $client_id)['total_return_by_client'];
                return $totalReturn;
            })
            ->editColumn('due', function ($row) {
                $client_id = $row->account->client_id ?? '';
                $totalReturn = $this->allWallets(Auth::user()->created_by, $client_id)['total_return_by_client'];
                $totalDeposit = $this->allWallets(Auth::user()->created_by, $client_id)['total_deposit_by_client'] - $totalReturn;
                $totalSale = $this->allWallets(Auth::user()->created_by, $client_id)['total_sale_by_client'] + $row->previous_due; // it's due
                if ($totalSale > $totalDeposit) {
                    $amount = $totalSale - $totalDeposit;
                    $due = $amount;
                } elseif ($totalSale == $totalDeposit) {
                    $due = '0';
                } else {
                    $due = '0';
                }
                return $due;
            })
            ->editColumn('adv', function ($row) {
                $client_id = $row->account->client_id ?? '';
                $totalReturn = $this->allWallets(Auth::user()->created_by, $client_id)['total_return_by_client'];
                $totalDeposit = $this->allWallets(Auth::user()->created_by, $client_id)['total_deposit_by_client'] - $totalReturn;
                $totalSale = $this->allWallets(Auth::user()->created_by, $client_id)['total_sale_by_client'] + $row->previous_due; // it's due
                if ($totalSale > $totalDeposit) {
                    $adv = '0';
                } elseif ($totalSale == $totalDeposit) {
                    $adv = '0';
                } else {
                    $amount = $totalDeposit - $totalSale;
                    $adv = $amount;
                }
                return $adv;
            })
            ->editColumn('gender', function ($row) {
                if ($row->gender == 1) {
                    return 'Male';
                } else {
                    return 'Female';
                }
            })
            ->rawColumns(['full_name', 'dt_id']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Client $model): QueryBuilder
    {
        return $model->latest()->newQuery();
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
                Button::make('reload'),
                Button::make('colvis')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('dt_id')->title(__('messages.sl')),
            Column::make('client_name')->title(__('messages.client')),
            Column::make('phone')->title(__('messages.phone_number')),
            Column::make('previous_due')->title(__('messages.previous_due')),
            Column::make('total_sale')->title(__('messages.total') . ' ' . __('messages.sales')),
            Column::make('total_bill')->title(__('messages.total') . ' ' . __('messages.bill')),
            Column::make('total_receive')->title(__('messages.receive')),
            Column::make('total_due')->title(__('messages.due')),
            Column::make('total_advance')->title(__('messages.advance')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DueReport_' . date('YmdHis');
    }
}
