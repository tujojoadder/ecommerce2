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

class ExpenseReportDataTable extends DataTable
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
            ->editColumn('account_id', function ($row) {
                return $row->account->title ?? '---';
            })
            ->editColumn('category_id', function ($row) {
                return $row->expenseCategory->name ?? '---';
            })
            ->editColumn('transaction_type', function ($row) {
                if ($row->transaction_type == 'money_return') {
                    return "<span class='badge bg-warning shadow-none'>" . ucwords(str_replace('_', ' ', $row->transaction_type)) . "</span>";
                } else if ($row->transaction_type == 'supplier_payment') {
                    return "<span class='badge bg-info shadow-none'>" . ucwords(str_replace('_', ' ', $row->transaction_type)) . "</span>";
                } else if ($row->transaction_type == 'staff_payment') {
                    return "<span class='badge bg-success shadow-none'>" . ucwords(str_replace('_', ' ', $row->transaction_type)) . "</span>";
                } else if ($row->transaction_type == 'transfer') {
                    return "<span class='badge bg-secondary shadow-none'>" . ucwords(str_replace('_', ' ', $row->transaction_type)) . "</span>";
                } else if ($row->transaction_type == 'purchase') {
                    return "<span class='badge bg-primary shadow-none'>" . ucwords(str_replace('_', ' ', $row->transaction_type)) . "</span>";
                }
            })
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'expense-edit']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="editExpense(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'expense-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
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
        $model = $model->whereIn('type', ['cost', 'return'])->where('deleted_at', null)->orderBy('date', 'desc')->newQuery();
        if (request()->has('supplier-payment')) {
            $model->where('type', 'cost')->where('transaction_type', 'supplier_payment');
        }
        if (request()->has('staff-payment')) {
            $model->where('type', 'cost')->where('transaction_type', 'staff_payment');
        }
        if (request()->has('money-return')) {
            $model->where('type', 'cost')->where('transaction_type', 'money_return');
        }
        if (request()->category_id) {
            $model->where('type', 'cost')->where('category_id', request()->category_id);
        }
        if (request()->subcategory_id) {
            $model->where('type', 'cost')->where('subcategory_id', request()->subcategory_id);
        }
        if (request()->client_id) {
            $model->where('type', 'cost')->where('client_id', request()->client_id);
        }
        if (request()->supplier_id) {
            $model->where('type', 'cost')->where('supplier_id', request()->supplier_id);
        }
        if (request()->starting_date && request()->ending_date) {
            $model->where('type', 'cost')->whereBetween('date', [enSearchDate(request()->starting_date, request()->ending_date)]);
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
            Column::make('dt_id')->addClass('bg-white text-center')->title(__('messages.id_no'))->width('5%'),
            Column::make('date')->title(__('messages.date'))->addClass('text-center'),
            Column::make('id')->title(__('messages.voucher_no'))->addClass('text-center')->orderable(false),
            Column::make('category_id')->title(__('messages.category'))->addClass('text-center')->orderable(false),
            Column::make('account_id')->title(__('messages.account'))->addClass('text-center')->orderable(false),
            Column::make('cheque_no')->title(__('messages.cheque_no'))->addClass('text-center')->orderable(false),
            Column::make('description')->title(__('messages.description'))->addClass('text-center')->orderable(false),
            Column::make('transaction_type')->title(__('messages.type'))->addClass('text-center')->orderable(false),
            Column::make('amount')->title(__('messages.amount'))->addClass('text-center')->orderable(false),
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
