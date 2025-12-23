<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\SmsLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmsLogDataTable extends DataTable
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
            ->addColumn('sent_to', function ($row) {
                if ($row->client_id == !null) {
                    $name = $row->client->client_name ?? '';
                    return $name . ' (' . __('messages.client') . ')';
                }
                if ($row->supplier_id == !null) {
                    $name = $row->supplier->supplier_name ?? '';
                    return $name . ' (' . __('messages.supplier') . ')';
                }
            })
            ->editColumn('schedule_at', function ($row) {
                return date('d M Y', strtotime($row->schedule_at));
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 0) {
                    if ($row->client_id == !null) {
                        return '<a href="' . route('user.sms.send.to.client') . '?message_body=' . $row->message_body . '&client_id=' . $row->client_id . '&url=schedule&log_id=' . $row->id . '" class="btn btn-sm btn-info my-1 rounded-lg">' . __('messages.send_now') . '</a>';
                    } else {
                        return '<a href="' . route('user.sms.send.to.supplier') . '?message_body=' . $row->message_body . '&supplier_id=' . $row->supplier_id . '&url=schedule&log_id=' . $row->id . '" class="btn btn-sm btn-info my-1 rounded-lg">' . __('messages.send_now') . '</a>';
                    }
                } else {
                    return '<span class="btn btn-sm btn-success my-1 rounded-lg">' . __('messages.success') . '</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $editbtn = '<a href="javascript:;" id="incomeCategoryEditBtn" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>';
                $deletebtn = '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                // return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SmsLog $model): QueryBuilder
    {
        $model = $model->whereNotNull('schedule_at')->newQuery();
        if (request()->client_id) {
            $model->where('client_id', request()->client_id);
        }
        if (request()->supplier_id) {
            $model->where('supplier_id', request()->supplier_id);
        }
        if (request()->starting_date && request()->ending_date) {
            $date = enSearchDate(request()->starting_date, request()->ending_date);
            $model->whereBetween('created_at', [$date]);
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
                Button::make('pdf'),
                Button::make('print'),
                Button::make('excel'),
                // Button::make('colvis')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('dt_id')->addClass('bg-white text-center')->width('5%')->title(__('messages.id_no')),
            Column::make('sent_to')->addClass('text-center')->title(__('messages.sent_to')),
            Column::make('message_body')->addClass('text-center')->title(__('messages.message_body')),
            Column::make('schedule_at')->addClass('text-center')->title(__('messages.schedule_at')),
            Column::make('status')->addClass('text-center')->title(__('messages.status')),
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
        return 'SmsLog_' . date('YmdHis');
    }
}
