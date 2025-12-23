<?php

namespace App\DataTables;

use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
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
            ->editColumn('remaining_due_date', function ($row) {
                $date = $row->remaining_due_date != null ? bnDateFormat($row->remaining_due_date) : '';
                $button = '<a href="javascript:;" onclick="remainingDueDate(' . $row->id . ');" class=""><i style="font-size: 16px !important;" class="py-1 fas fa-calendar-check"></i> '. $date .'</a>';
                return $button;
            })
            ->editColumn('sales', function ($row) {
                return ClientBalanceHelper::getClientTotalSales(Invoice::class, $row->id);
            })
            ->editColumn('client_name', function ($row) {
                return 'Name: ' . $row->client_name . ' | Phone: ' . $row->phone;
            })
            ->editColumn('receive', function ($row) {
                return ClientBalanceHelper::getClientTotalDeposits(Transaction::class, $row->id);
            })
            ->editColumn('return', function ($row) {
                return ClientBalanceHelper::getClientTotalMoneyReturn(Transaction::class, $row->id);
            })
            ->editColumn('due', function ($row) {
                if (request()->is('user/client/remaining/due/date')) {
                    $payBtn = Gate::any(['access-all', 'receive-visibility', 'receive-create']) ? '<a href="' . route('user.receive.index') . '?create&client_id=' . $row->id . '" class="" style="color: #3858f9 !important;"><i style="font-size: 16px !important; color: #3858f9 !important;" class="py-1 fas fa-hand-holding-usd"></i>' . __('messages.receive') . '</a>' : '';
                } else {
                    $payBtn = '';
                }
                return ClientBalanceHelper::getClientTotalDue(Transaction::class, $row->id) . ' ' . $payBtn;
            })
            ->addColumn('image', function ($row) {
                return view('user.client.includes.image', compact('row'))->render();
            })
            ->addColumn('client_info', function ($row) {
                return view('user.client.includes.client_info', compact('row'))->render();
            })
            ->addColumn('account', function ($row) {
                $wallet = $this;
                return view('user.client.includes.wallet', compact('row', 'wallet'))->render();
            })
            ->addColumn('action', function ($row) {
                return view('user.client.includes.action', compact('row'))->render();
            })
            ->rawColumns(['action', 'image', 'client_info', 'account', 'remaining_due_date', 'due'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Client $model): QueryBuilder
    {
        $model = $model->where('deleted_at', null)->where('type', 0)->latest()->newQuery();
        if (request()->is('user/client/remaining/due/date')) {
            $model->where('remaining_due_date', '!=', null);
        }
        if (request()->client_group) {
            $model->where('group_id', request()->client_group);
        }
        if (request()->starting_date && request()->ending_date) {
            $date = enSearchDate(request()->start_date, request()->ending_date);
            $model->whereBetween('created_at', [$date]);
        }
        if (request()->search_text) {
            $searchText = request()->search_text;
            $model->where('client_name', 'like', '%' . $searchText . '%')
                ->orWhere('company_name', 'like', '%' . $searchText . '%')
                ->orWhere('fathers_name', 'like', '%' . $searchText . '%')
                ->orWhere('mothers_name', 'like', '%' . $searchText . '%')
                ->orWhere('address', 'like', '%' . $searchText . '%')
                ->orWhere('phone', 'like', '%' . $searchText . '%')
                ->orWhere('phone_optional', 'like', '%' . $searchText . '%')
                ->orWhere('email', 'like', '%' . $searchText . '%')
                ->orWhere('upazilla_thana', 'like', '%' . $searchText . '%')
                ->orWhere('zip_code', 'like', '%' . $searchText . '%');
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
            ->addTableClass('table-bordered table-hover')
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
            Column::make('dt_id')->title('SL')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('image')->printable(false)->exportable(false)->width('15%')->title(__('messages.image')),
            Column::make('client_info')->title(__('messages.client') . ' ' . __('messages.details')),
            Column::make('account')->title(__('messages.details')),
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
        return 'Client_' . date('YmdHis');
    }
}
