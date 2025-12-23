<?php

namespace App\DataTables;

use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\BalanceTrait;
use App\Helpers\Traits\RowIndex;
use App\Models\Client;
use App\Models\ClientLoan;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LoanClientDataTable extends DataTable
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
            ->addColumn('image', function ($row) {
                $asset = $row->image != null ? asset('storage/profile/' . $row->image) : asset('dashboard/img/user-bg.png');

                $picture = '<div class="image-show">
                                <img class="rounded-circle border image-main" src="' . $asset . '" alt="" height="100" width="100">
                            </div>';
                $image = '<input type="file" name="image" class="border image-input" style="width: 40%;">';
                $button = '<button class="btn btn-sm btn-secondary rounded-0 py-0">Save</button>';
                $form = '<form action="' . route('user.client.update.image', $row->id) . '" method="POST" enctype="multipart/form-data">
                            ' . csrf_field() . '
                            ' . method_field('PUT') . '
                            <div class="input-group justify-content-center">
                                ' . $image . '
                                ' . $button . '
                            </div>
                        </form>';

                $div = '<div class="text-center">
                            ' . $picture . '
                            <br><br>
                            ' . $form . '
                        </div>';
                $modal = <<<HTML
                        <!-- Modal -->
                        <div class="modal fade" id="productPicture$row->id">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Name: $row->client_name</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-2 d-flex justify-content-center">
                                <img class="border" src=$asset class="w-100">
                            </div>
                            <div class="modal-footer py-1">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                HTML;
                return $div . $modal;
            })
            ->addColumn('client_info', function ($row) {
                $name = $row->client_name;
                $companyName = $row->company_name;
                $fathersName = $row->fathers_name;
                $mothersName = $row->mothers_name;
                $phone = $row->phone . ', ' . $row->phone_optional;
                $email = $row->email;
                $group = $row->group->name ?? null;
                $address = $row->address;
                $status = $row->status ? '<span class="text-success">Activated</span>' : '<span class="text-danger">Dectivated</span>';
                $client_info = '
                    <table class="table table-sm table-borderless my-2">
                        <tr class="bg-transparent ' . ($name == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.name') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $name . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($companyName == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.company_name') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $companyName . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($fathersName == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.fathers_name') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $fathersName . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($mothersName == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.mothers_name') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $mothersName . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($phone == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.phone') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $phone . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($email == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.email') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $email . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($group == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.client_group') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $group . '</td>
                        </tr>
                        <tr class="bg-transparent ' . ($address == null ? "d-none" : "") . '">
                            <td width="20%" class="font-weight-bolder">' . __('messages.address') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $address . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td width="20%" class="font-weight-bolder">' . __('messages.status') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . $status . '</td>
                        </tr>
                        <tr class="bg-transparent">
                            <td width="20%" class="font-weight-bolder">' . __('messages.created_at') . '</td>
                            <td width="1%" class="font-weight-bolder">:</td>
                            <td>' . date('d M Y', strtotime($row->created_at)) . '</td>
                        </tr>
                    </table>
                ';
                return $client_info;
            })
            ->addColumn('account', function ($row) {
                $client_id = $row->id;

                $loanBalance = ClientBalanceHelper::getClientTotalLoanBalance($client_id) . ' ৳';
                $loanPayment = ClientBalanceHelper::getClientTotalLoanPayment($client_id) . ' ৳';
                $loanReceive = ClientBalanceHelper::getClientTotalLoanReceive($client_id) . ' ৳';

                $balance = '<span class="mb-1 px-2 rounded">' . __('messages.balance') . '</span>';
                $payment = '<span class="mb-1 px-2 rounded">' . __('messages.loan_payment') . '</span>';
                $receive = '<span class="mb-1 px-2 rounded">' . __('messages.loan_receive') . '</span>';

                if ($loanBalance < 0) {
                    $dueOrAdv = '<span class="text-success small">' .  $loanBalance . '</span>';
                } else {
                    $dueOrAdv = '<span class="text-danger small">' .  $loanBalance . '</span>';
                }

                $table = <<<HTML
                    <table class="table table-sm table-bordered mb-0">
                        <tr class="bg-white">
                            <td class="py-0 w-50">$receive</td>
                            <td class="py-0">$loanReceive</td> <!-- Total Return -->
                        </tr>
                        <tr class="bg-white">
                            <td class="py-0 w-50">$payment</td>
                            <td class="py-0">$loanPayment</td> <!-- Total Return -->
                        </tr>
                        <tr class="bg-white">
                            <td class="w-50">$balance</td>
                            <td class="py-0">
                                $dueOrAdv
                            </td>
                        </tr>
                    </table>
                HTML;
                return $table;
            })
            ->addColumn('action', function ($row) {
                if ($row->status == 1) {
                    $togglerIconText = '<i class="fas fa-toggle-off"></i>' . __('messages.deactive');
                } else {
                    $togglerIconText = '<i class="fas fa-toggle-on"></i>' . __('messages.active');
                }
                $activeOrDeactive = Gate::any(['access-all', 'client-add']) ? '<a href="javascript:;" onclick="activeToggle(' . $row->id . ')" class="dropdown-item"> ' . $togglerIconText . '</a>' : '';
                $viewbtn = Gate::any(['access-all', 'client-view']) ? '<a href="javascript:;" onclick="view(' . $row->id . ')" class="dropdown-item"> <i class="fas fa-eye"></i> View</a>' : '';
                $receive = Gate::any(['access-all', 'receive-visibility', 'receive-create']) ?  '<a href="' . route('user.loan.index') . '?create-receive&client_id=' . $row->id . '" class="dropdown-item"> <i class="fas fa-hand-holding-usd"></i> ' . __('messages.receive') . '</a>' : '';
                $editbtn = Gate::any(['access-all', 'client-edit']) ? '<a href="' . route('user.client.edit', $row->id) . '" class="dropdown-item"><i class="fas fa-pen"></i> ' . __('messages.edit') . '</a>' : '';
                $deletebtn = Gate::any(['access-all', 'client-delete']) ? '<a href="javascript:;" class="dropdown-item" onclick="destroy(' . $row->id . ')"><i class="fas fa-trash"></i> ' . __('messages.delete') . '</a>' : '';
                $viewStatement = Gate::any(['access-all', 'client-view']) ? '<a href="' . route('user.client.statements') . '?&client_id=' . $row->id . '" class="dropdown-item"><i class="fas fa-receipt"></i> ' . __('messages.view') . ' ' . __('messages.statement') . '</a>' : '';
                $dropdown = '
                    <div class="dropdown bg-transparrent">
                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-success" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">Action<i class="fas fa-caret-down ms-1"></i></button>
                        <div  class="dropdown-menu tx-13 shadow">
                            ' . $activeOrDeactive . '
                            ' . $viewbtn . '
                            ' . $receive . '
                            ' . $editbtn . '
                            ' . $deletebtn . '
                            ' . $viewStatement . '
                        </div>
                    </div>
                ';
                return $dropdown;
            })
            ->rawColumns(['action', 'image', 'client_info', 'account'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Client $model): QueryBuilder
    {
        // type 0 == loan client
        $model = $model->where('type', '1')->where('deleted_at', null)->latest()->newQuery();
        if (request()->client_group) {
            $model->where('group_id', request()->client_group);
        }
        if (request()->starting_date && request()->ending_date) {
            $date = enSearchDate(request()->starting_date, request()->ending_date);
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
        return 'ClientLoan_' . date('YmdHis');
    }
}
