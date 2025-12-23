<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseReport;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PurchaseReportDataTable extends DataTable
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
                return bnDateFormat($row->purchase->issued_date ?? now());
            })
            ->editColumn('product_id', function ($row) {
                return $row->product->name ?? '---';
            })
            ->editColumn('group', function ($row) {
                return $row->product->group->name ?? '---';
            })
            ->editColumn('supplier_id', function ($row) {
                return $row->purchase->supplier->supplier_name ?? '---';
            })
            ->addColumn('action', function ($row) {
                // $editbtn = '<a href="javascript:;" data-bs-toggle="collapse" data-bs-target="#invoiceCollapse" aria-expanded="false" aria-controls="invoiceCollapse" class="btn btn-sm mx-1 btn-info" onclick="edit(' . $row->id . ')"><i class="fas fa-pen-nib"></i></a>';
                $deletebtn = '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->addColumn('printable', function ($row) {
                $print = '<a href="javascript:;" class="btn btn-sm mx-1 btn-primary" onclick="printInvoice(' . $row->id . ')"><i class="fas fa-print"></i></a>';
                $dropdown = '
                    <div class="text-center">
                    ' . $print . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'supplier_id', 'printable', 'description']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PurchaseItem $model)
    {
        $supplier_id = $_GET['supplier_id'] ?? null;
        if ($supplier_id !== null) {
            $purchases = Purchase::where('supplier_id', $supplier_id)->get() ?? null;

            if ($purchases !== null) {
                return $model->whereIn('purchase_id', $purchases->pluck('id'))
                    ->with(['purchase', 'product'])
                    ->where('deleted_at', null)
                    ->latest();
            }
        } else {
            $model = $model->with(['purchase', 'product'])->where('deleted_at', null)->latest()->newQuery();

            if (request()->filled('select_supplier_id')) {
                $model->whereHas('purchase', function ($query) {
                    $query->where('supplier_id', request()->select_supplier_id);
                });
            }
            if (request()->filled('product_id')) {
                $model->where('product_id', request()->product_id);
            }
            if (request()->filled('starting_date') && request()->filled('ending_date')) {
                $dates = enSearchDate(request()->starting_date, request()->ending_date);
                $model->whereHas('purchase', function ($query) use ($dates) {
                    return $query->whereBetween('issued_date', [$dates]);
                });
            }

            if (request()->filled('product_name')) {
                $productName = request()->product_name;
                $model->whereHas('product', function ($query) use ($productName) {
                    $query->where('name', 'like', '%' . $productName . '%')
                        ->orWhere('description', 'like', '%' . $productName . '%');
                });
            }
            if (request()->filled('invoice_no')) {
                $model->whereHas('purchase', function ($query) {
                    $query->where('invoice_id', request()->invoice_no);
                });
            }
            if (request()->is('user/purchase/return*')) {
                $model->whereHas('purchase', function ($query) {
                    $query->where('status', 4);
                });
            } else {
                $model->whereHas('purchase', function ($query) {
                    $query->where('status', 0);
                });
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
            ->addTableClass('table table-bordered')
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
            Column::make('dt_id')->orderable(true)->title(__('messages.id_no')),
            Column::make('created_at')->title(__('messages.date'))->addClass('bg-white')->orderable(false),
            Column::make('supplier_id')->title(__('messages.supplier'))->searchable(false)->orderable(false),
            Column::make('product_id')->title(__('messages.product')),
            Column::make('group')->title(__('messages.group')),
            Column::make('buying_price')->title(__('messages.buying') . ' ' . __('messages.price')),
            Column::make('selling_price')->title(__('messages.selling') . ' ' . __('messages.price')),
            Column::make('quantity')->title(__('messages.quantity')),
            Column::make('total_buying_price')->title(__('messages.total') . ' ' . __('messages.buying') . ' ' . __('messages.price')),
            Column::make('description')->title(__('messages.description')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PurchaseReport_' . date('YmdHis');
    }
}
