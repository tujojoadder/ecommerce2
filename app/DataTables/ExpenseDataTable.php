<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ExpenseDataTable extends DataTable
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
            ->editColumn('created_at', function ($row) {
                return bnDateFormat($row->date);
            })
            ->editColumn('expense_type', function ($row) {
                return str_replace('_', ' ', ucwords($row->expense_type));
            })
            ->editColumn('receipt_for', function ($row) {
                $client = $row->client->client_name ?? null;
                $supplier = $row->supplier->supplier_name ?? null;
                $staff = $row->staff->name ?? null;
                if ($client == !null) {
                    return $client;
                }
                if ($supplier == !null) {
                    return $supplier;
                }
                if ($staff == !null) {
                    return $staff;
                }
            })
            ->editColumn('account_id', function ($row) {
                return $row->account->title ?? '---';
            })
            ->editColumn('bank_id', function ($row) {
                return $row->bank->name ?? '---';
            })
            ->editColumn('category_id', function ($row) {
                if ($row->transaction_type == 'invoice-return') {
                    return __('messages.sales') . ' ' . __('messages.return');
                }
                return ucwords($row->expenseCategory->name ?? '---');
            })
            ->editColumn('transaction_type', function ($row) {
                if ($row->transaction_type == 'money_return') {
                    return "<span class='badge bg-warning shadow-none'>" . __('messages.money') . ' ' . __('messages.return') . "</span>";
                } else if ($row->transaction_type == 'supplier_payment') {
                    return "<span class='badge bg-info shadow-none'>" . __('messages.supplier') . ' ' . __('messages.payment') . "</span>";
                } else if ($row->transaction_type == 'staff_payment') {
                    return "<span class='badge bg-success shadow-none'>" . __('messages.staff') . ' ' . __('messages.payment') . "</span>";
                } else if ($row->transaction_type == 'transfer') {
                    return "<span class='badge bg-secondary shadow-none'>" . __('messages.transfer') . "</span>";
                } else if ($row->transaction_type == 'purchase') {
                    return "<span class='badge bg-primary shadow-none'>" . __('messages.purchase') . "</span>";
                } else if ($row->transaction_type == 'cost') {
                    return "<span class='badge bg-danger shadow-none'>" . __('messages.cost') . "</span>";
                } else if ($row->transaction_type == 'personal_expense') {
                    return "<span class='badge bg-info shadow-none'>" . __('messages.personal_expense') . "</span>";
                } else if ($row->transaction_type == 'invoice-return') {
                    return "<span class='badge bg-info shadow-none'>" . __('messages.sales') . ' ' . __('messages.return') . "</span>";
                }
            })
            ->addColumn('action', function ($row) {
                if ($row->transaction_type == 'purchase' || $row->transaction_type == 'invoice-return') {
                    $disabled = 'disabled';
                } else {
                    $disabled = '';
                }
                $editbtn = Gate::any(['access-all', 'expense-edit', 'staff-payment-edit']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-info ' . $disabled . '" onclick="editExpense(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'expense-delete', 'staff-payment-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger ' . $disabled . '" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . '
                    ' . $deletebtn . '
                    </dvi>
                    ';
                return $dropdown;
            })
            ->addColumn('printable', function ($row) {
                $print = '<a href="javascript:;" class="btn btn-sm mx-1 btn-success"  onclick="printReceipt(' . $row->id . ')"><i class="fas fa-print"></i></a>';
                $dropdown = '
                    <div class="text-center">
                    ' . $print . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'printable', 'transaction_type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        if (request()->query_string == 'daily-expense' || request()->query_string == 'create-daily-expense') {
            $model = $model->where('deleted_at', null)->orderBy('date', 'desc')->newQuery();
            $model->where('transaction_type', 'daily_expense');
            return $model;
        } else {
            $model = $model->whereIn('type', ['cost', 'return'])->where('deleted_at', null)->orderBy('date', 'desc')->newQuery();
            if (request()->query_string == 'supplier-payment' || request()->supplier_id) {
                $model->whereIn('transaction_type', ['supplier_payment', 'purchase']);
            }
            if (request()->query_string == 'personal-expense' || request()->query_string == 'create-personal-expense') {
                $model->whereIn('transaction_type', ['personal_expense']);
            }
            if (request()->query_string == 'staff-payment') {
                $model->where('transaction_type', 'staff_payment');
                if (request()->select_staff_id) {
                    $model->where('staff_id', request()->select_staff_id);
                }
                if (request()->starting_date && request()->ending_date) {
                    $model->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
                }
            }
            if (request()->query_string == 'money-return') {
                $model->where('transaction_type', 'money_return');
            }
            if (request()->is('user/report/expense/supplier/payment')) {
                if (request()->has('supplier_id')) {
                    $model->where('supplier_id', request()->supplier_id)->where('transaction_type', 'supplier_payment');
                } else {
                    $model->where('transaction_type', 'supplier_payment');
                }
            }
            if (request()->client_id) {
                $model->whereNot('transaction_type', ['purchase'])->where('client_id', request()->client_id);
            }
            if (request()->select_supplier_id) {
                $model->whereNot('transaction_type', ['supplier_payment'])->where('supplier_id', request()->select_supplier_id);
            }
            if (request()->starting_date && request()->ending_date) {
                $model->whereNot('transaction_type', ['purchase'])->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
            }
            $onlyCostCondition = request()->query_string == 'daily-expense' || request()->query_string == 'create-daily-expense' || request()->query_string == 'personal-expense' || request()->query_string == 'create-personal-expense' || request()->query_string == 'staff-payment' || request()->query_string == 'money-return' || request()->query_string == 'supplier-payment';
            if (config('expenses_show_only_cost_list') == 1) {
                if (!$onlyCostCondition) {
                    if (config('expenses_show_money_return_into_list') == 1) {
                        $model->whereIn('type', ['cost', 'return'])->whereIn('transaction_type', ['cost', 'money_return']);
                    } else {
                        $model->where('type', 'cost')->where('transaction_type', 'cost');
                    }
                }
            }
            return $model;
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
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.sl')),
            Column::make('created_at')->addClass('text-center')->title(__('messages.date')),
            Column::make('client_id')->addClass('text-center')->orderable(false)->title(__('messages.client')),
            Column::make('id')->addClass('text-center')->orderable(false)->title(__('messages.id_no')),
            Column::make('category_id')->addClass('text-center')->orderable(false)->title(__('messages.category')),
            Column::make('account_id')->addClass('text-center')->orderable(false)->title(__('messages.account')),
            Column::make('cheque_no')->addClass('text-center')->orderable(false)->title(__('messages.check_no')),
            Column::make('description')->addClass('text-center')->orderable(false)->title(__('messages.description')),
            Column::make('transaction_type')->addClass('text-center')->orderable(false)->title(__('messages.transaction') . ' ' . __('messages.type')),
            Column::make('expense_type')->addClass('text-center')->orderable(false)->title(__('messages.expense_type')),
            Column::make('amount')->addClass('text-center')->orderable(false)->title(__('messages.amount')),
            Column::computed('printable')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title(__('messages.printable')),
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
        return 'Expense_' . date('YmdHis');
    }
}
