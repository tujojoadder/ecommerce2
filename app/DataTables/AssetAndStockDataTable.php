<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\AssetAndStock;
use App\Models\Product;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountGroup;
use App\Models\Supplier;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;


class AssetAndStockDataTable extends DataTable
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
            ->addColumn('supplier_id', function ($row) {
                $supplier = Supplier::where('id', $row->supplier_id)->first();
                if ($supplier != null) {

                    $supplier_name = $supplier->supplier_name;
                    return $supplier_name;
                }
            })
            ->addColumn('product_details', function ($row) {
                $product = Product::where('id', $row->product_id)->first();
                $chart_id = ChartOfAccount::where('id', $row->chart_oF_account_id)->first();
                $chart_group_id = ChartOfAccountGroup::where('id', $row->chart_oF_account_group_id)->first();
                if ($product != null) {

                    $product_info = '
                    <table class="table table-sm table-borderless mb-0">
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Name</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $product->name . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Type</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->asset_type . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Unit</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->unit . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Quantity</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->quantity . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Rate</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->rate . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Chart Of account</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->chart_of_account_id . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="font-weight-bolder">Chart Of account group</td>
                            <td class="font-weight-bolder">:</td>
                            <td>' . $row->chart_of_account_group_id . '</td>
                        </tr>

                    </table>
                ';


                    return $product_info;
                }
            })
            ->addColumn('date', function ($row) {
                $date = $row->date;
                return $date;
            })
            ->addColumn('category', function ($row) {
                $category = $row->category;
                return $category;
            })
            ->addColumn('account', function ($row) {
                $account = Account::where('id', $row->account)->first();
                if ($account != null) {

                    $account_name = $account->title;
                    return $account_name;
                }
            })
            ->addColumn('id_no', function ($row) {
                $id_no = $row->id_no;
                return $id_no;
            })
            ->addColumn('voucher_no', function ($row) {
                $voucher_no = $row->voucher_no;
                return $voucher_no;
            })
            ->addColumn('description', function ($row) {
                $description = $row->description;
                return $description;
            })

            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })

            ->addColumn('action', function ($row) {
                $editbtn = '<a href="javascript:;" onclick="edit(' . $row->id . ')"  class="btn btn-sm mx-1 btn-info" ><i class="fas fa-pen-nib"></i></a>';
                $deletebtn = '<a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                $dropdown = '
                    <div class="d-flex justify-content-between">
                    ' . $editbtn . $deletebtn . '
                    </dvi>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'dt_id', 'product_details', 'image']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AssetAndStock $model): QueryBuilder
    {
        // if (request()->has('asset')) {
        //     return $model->where('type','asset')->newQuery();


        // }
        // else{
        // }
        return $model->where('deleted_at', null)->latest()->newQuery();
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
            Column::make('supplier_id')->addClass('text-center')->title(__('messages.supplier')),
            Column::make('product_details')->addClass('text-center')->title(__('messages.product').' '.__('messages.details')),
            Column::make('date')->addClass('text-center')->title(__('messages.date')),
            Column::make('category')->addClass('text-center')->title(__('messages.category')),
            Column::make('account')->addClass('text-center')->title(__('messages.account')),
            Column::make('id_no')->addClass('text-center')->title(__('messages.id_no')),
            Column::make('voucher_no')->addClass('text-center')->title(__('messages.voucher_no')),
            Column::make('description')->addClass('text-center')->title(__('messages.description')),
            Column::make('created_at')->title(__('messages.created_at')),
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
        return 'Product_' . date('YmdHis');
    }
}
