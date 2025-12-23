<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\CompanyInformation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompanyInformationDataTable extends DataTable
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
            ->addColumn('company_name', function ($row) {
                $company_name = $row->company_name;
                return $company_name;
            })
            ->addColumn('company_type', function ($row) {
                $company_type = $row->company_type;
                return $company_type;
            })
            ->addColumn('logo', function ($row) {
                $logo = $row->logo;
                return $logo;
            })
            ->addColumn('homepage_banner', function ($row) {
                $homepage_banner = $row->homepage_banner;
                return $homepage_banner;
            })
            ->addColumn('invoice_header', function ($row) {
                $invoice_header = $row->invoice_header;
                return $invoice_header;
            })
            ->addColumn('email', function ($row) {
                $email = $row->email;
                return $email;
            })
            ->addColumn('phone', function ($row) {
                $phone = $row->phone;
                return $phone;
            })
            ->addColumn('country', function ($row) {
                $country = $row->country;
                return $country;
            })
            ->addColumn('address1', function ($row) {
                $address1 = $row->address1;
                return $address1;
            })
            ->addColumn('address2', function ($row) {
                $address2 = $row->address2;
                return $address2;
            })
            ->addColumn('city', function ($row) {
                $city = $row->city;
                return $city;
            })
            ->addColumn('state', function ($row) {
                $state = $row->state;
                return $state;
            })
            ->addColumn('post_code', function ($row) {
                $post_code = $row->post_code;
                return $post_code;
            })
            ->addColumn('stock_warning', function ($row) {
                $stock_warning = $row->stock_warning;
                return $stock_warning;
            })
            ->addColumn('currency_symbol', function ($row) {
                $currency_symbol = $row->currency_symbol;
                return $currency_symbol;
            })
            ->addColumn('sms_api_code', function ($row) {
                $sms_api_code = $row->sms_api_code;
                return $sms_api_code;
            })
            ->addColumn('sms_api_sender', function ($row) {
                $sms_api_sender = $row->sms_api_sender;
                return $sms_api_sender;
            })
            ->addColumn('sms_api_provider', function ($row) {
                $sms_api_provider = $row->sms_api_provider;
                return $sms_api_provider;
            })
            ->addColumn('sms_api_setting', function ($row) {
                $sms_api_setting = $row->sms_api_setting;
                return $sms_api_setting;
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
    public function query(CompanyInformation $model): QueryBuilder
    {
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
            Column::make('company_name')->addClass('text-center')->title(__('messages.company').' '.__('messages.name')),
            Column::make('company_type')->addClass('text-center')->title(__('messages.company').' '.__('messages.type')),
            Column::make('homepage_banner')->addClass('text-center')->title(__('messages.banner')),
            Column::make('invoice_header')->addClass('text-center')->title(__('messages.invoice_header')),
            Column::make('email')->addClass('text-center')->title(__('messages.email')),
            Column::make('phone')->addClass('text-center')->title(__('messages.phone_number')),
            Column::make('country')->addClass('text-center')->title(__('messages.country')),
            Column::make('address1')->addClass('text-center')->title(__('messages.address')),
            Column::make('address2')->addClass('text-center')->title(__('messages.address')),
            Column::make('city')->addClass('text-center')->title(__('messages.city')),
            Column::make('state')->addClass('text-center')->title(__('messages.state')),
            Column::make('post_code')->addClass('text-center')->title(__('messages.post_code')),
            Column::make('stock_warning')->addClass('text-center')->title(__('messages.stock_warning')),
            Column::make('currency_symbol')->addClass('text-center')->title(__('messages.currency_symbol')),
            Column::make('sms_api_code')->addClass('text-center')->title(__('messages.sms_api_code')),
            Column::make('sms_api_sender')->addClass('text-center')->title(__('messages.sms_api_provider')),
            Column::make('sms_api_provider')->addClass('text-center')->title(__('messages.sms_appi_provider')),
            Column::make('sms_api_setting')->addClass('text-center')->title(__('messages.sms_api_setting')),
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
