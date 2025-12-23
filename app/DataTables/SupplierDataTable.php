<?php

namespace App\DataTables;

use App\Helpers\SupplierBalanceHelper;
use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Purchase;
use App\Models\Supplier;
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

class SupplierDataTable extends DataTable
{
    use BalanceTrait, RowIndex;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->addColumn('dt_id', function ($row) {
                return $this->dt_index($row);
            })
            ->editColumn('remaining_due_date', function ($row) {
                $date = $row->remaining_due_date != null ? bnDateFormat($row->remaining_due_date) : '';
                $button = '<a href="javascript:;" onclick="remainingDueDate(' . $row->id . ');" class=""><i style="font-size: 16px !important;" class="py-1 fas fa-calendar-check"></i></a>';
                return $button . ' ' . $date;
            })
            ->editColumn('purchase', function ($row) {
                return SupplierBalanceHelper::getTotalSales(Purchase::class, $row->id);
            })
            ->editColumn('supplier_name', function ($row) {
                return 'Name: ' . $row->supplier_name . ' | Phone: ' . $row->phone;
            })
            ->editColumn('receive', function ($row) {
                return SupplierBalanceHelper::getSupplierPayments(Transaction::class, $row->id);
            })
            ->editColumn('due', function ($row) {
                return SupplierBalanceHelper::getTotalDue(Transaction::class, $row->id);
            })
            ->addColumn('image', function ($row) {
                return view('user.supplier.includes.image', compact('row'))->render();
            })
            ->addColumn('supplier_info', function ($row) {
                return view('user.supplier.includes.supplier_info', compact('row'))->render();
            })
            ->addColumn('account', function ($row) {
                $wallet = $this->supplierWallets($row->id);
                return view('user.supplier.includes.wallet', compact('row', 'wallet'))->render();
            })
            ->addColumn('action', function ($row) {
                return view('user.supplier.includes.action', compact('row'))->render();
            })
            ->rawColumns(['action', 'image', 'supplier_info', 'account', 'remaining_due_date'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Supplier $model): QueryBuilder
    {
        $model = $model->where('deleted_at', null)->latest()->newQuery();
        if (request()->is('user/supplier/remaining/due/date')) {
            $model->where('remaining_due_date', '!=', null);
        }
        if (request()->search_text && request()->supplier_group) {
            $searchText = request()->search_text;
            $model->where('deleted_at', null)
                ->where('group_id', request()->supplier_group)
                ->where('supplier_name', 'like', '%' . $searchText . '%')
                ->orWhere('company_name', 'like', '%' . $searchText . '%')
                ->orWhere('address', 'like', '%' . $searchText . '%')
                ->orWhere('phone', 'like', '%' . $searchText . '%')
                ->orWhere('phone_optional', 'like', '%' . $searchText . '%')
                ->orWhere('email', 'like', '%' . $searchText . '%')
                ->orWhere('country_name', 'like', '%' . $searchText . '%')
                ->orWhere('bank_account', 'like', '%' . $searchText . '%')
                ->orWhere('city_state', 'like', '%' . $searchText . '%')
                ->orWhere('zip_code', 'like', '%' . $searchText . '%')
                ->latest()->newQuery();
        }
        if (request()->search_text) {
            $searchText = request()->search_text;
            $model->where('deleted_at', null)
                ->where('supplier_name', 'like', '%' . $searchText . '%')
                ->orWhere('company_name', 'like', '%' . $searchText . '%')
                ->orWhere('address', 'like', '%' . $searchText . '%')
                ->orWhere('phone', 'like', '%' . $searchText . '%')
                ->orWhere('phone_optional', 'like', '%' . $searchText . '%')
                ->orWhere('email', 'like', '%' . $searchText . '%')
                ->orWhere('country_name', 'like', '%' . $searchText . '%')
                ->orWhere('bank_account', 'like', '%' . $searchText . '%')
                ->orWhere('city_state', 'like', '%' . $searchText . '%')
                ->orWhere('zip_code', 'like', '%' . $searchText . '%')
                ->latest()->newQuery();
        }
        if (request()->supplier_group) {
            $model->where('group_id', request()->supplier_group)->where('deleted_at', null)->latest()->newQuery();
        }
        if (request()->starting_date && request()->ending_date) {
            $startDate = date('Y-m-d H:i:s', strtotime(request()->starting_date));
            $endDate = date('Y-m-d H:i:s', strtotime(request()->ending_date));
            $model->whereBetween('created_at', [$startDate, $endDate])->where('deleted_at', null)->latest()->newQuery();
        }
        if ((request()->supplier_group) && request()->starting_date && request()->ending_date) {
            $startDate = date('Y-m-d H:i:s', strtotime(request()->starting_date));
            $endDate = date('Y-m-d H:i:s', strtotime(request()->ending_date));
            $model->where('group_id', request()->supplier_group)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('deleted_at', null)->latest()->newQuery();
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
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('image')->exportable(true)->width('15%')->title(__('messages.image')),
            Column::make('supplier_info')->title(__('messages.supplier') . ' ' . __('messages.details')),
            Column::make('account')->title(__('messages.account')),
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center')->title(__('messages.action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Supplier_' . date('YmdHis');
    }
}
