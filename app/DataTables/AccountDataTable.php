<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Account;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AccountDataTable extends DataTable
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
            ->editColumn('initial_balance', function ($row) {
                $total = $row->balance($row->id);
                return number_format($total, 2);
            })
            ->editColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('action', function ($row) {
                $editbtn = Gate::any(['access-all', 'account-edit']) ? '<a href="' . route('user.account.edit', $row->id) . '" class="btn btn-sm mx-1 btn-info"><i class="fas fa-pen-nib"></i></a>' : '';
                $deletebtn = Gate::any(['access-all', 'account-delete']) ? '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>' : '';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                        ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'description']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Account $model): QueryBuilder
    {
        return $model->where('deleted_at', null)->newQuery();
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
            Column::make('id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('title')->title(__('messages.title')),
            Column::make('account_number')->title(__('messages.account')),
            Column::make('description')->title(__('messages.description')),
            Column::make('contact_person')->title(__('messages.contact_person')),
            Column::make('phone')->title(__('messages.phone_number')),
            // Column::make('initial_balance')->title('Balance'),
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
        return 'Account_' . date('YmdHis');
    }
}
