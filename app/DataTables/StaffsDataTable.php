<?php

namespace App\DataTables;

use App\Helpers\Traits\RowIndex;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StaffsDataTable extends DataTable
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
            ->editColumn('name', function ($row) {
                return $row->name . ' (' . $row->username . ') ';
            })
            ->addColumn('image', function ($row) {
                if ($row->image != null) {
                    $asset = asset('storage/profile/' . $row->image);
                } else {
                    $asset = asset('dashboard/img/user-bg.png');
                }
                $picture = '<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#productPicture' . $row->id . '"><img class="rounded-circle border" src="' . $asset . '" alt="" height="50" width="50"><a>';
                $image = '<input type="file" name="image" class="" style="width: 40%;">';
                $button = '<button class="btn btn-sm btn-secondary rounded-0 py-0">Save</button>';
                $div = '<div class="text-center">
                    ' . $picture . '
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
            ->addColumn('roles', function ($row) {
                if (count($row->getRoleNames()) < 0) {
                    return 'No role assigned';
                } else {
                    foreach ($row->getRoleNames() as $roleName) {
                        return $roleName . '<br>';
                    }
                }
            })
            ->addColumn('permissions', function ($row) {
                if (count($row->getPermissionNames()) < 0) {
                    return 'No permission assigned';
                } else {
                    $permissions = [];
                    foreach ($row->getPermissionNames() as $permissionName) {
                        $permissions[] = $permissionName . ',';
                    }

                    $allPermission = implode(PHP_EOL, $permissions);
                    return '<div class="btn btn-sm btn-success" title="' . $allPermission . '">Permissions</div>';
                }
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->addColumn('action', function ($row) {
                $user = request()->has('user') ? 'user' : '';
                $assignRole = Gate::any(['access-all']) ? '<a href="' . route('user.staff.assing.role', $row->id) . '" class="dropdown-item" onclick="edit(' . $row->id . ')">Assign Role</a>' : '';
                $assignPermission = Gate::any(['access-all']) ? '<a href="' . route('user.staff.assing.permission', $row->id) . '" class="dropdown-item" onclick="edit(' . $row->id . ')">Assign Permission</a>' : '';
                $editbtn = Gate::any(['access-all', 'staff-edit']) ? '<a href="' . route('user.staff.edit', $row->id) . '?' . $user . '" class="dropdown-item" onclick="edit(' . $row->id . ')">Edit</a>' : '';
                $deletebtn = Gate::any(['access-all', 'staff-delete']) ? '<a href="javascript:;" class="dropdown-item" onclick="destroy(' . $row->id . ')">Delete</a>' : '';
                $dropdown = '
                        <div class="dropdown bg-transparrent">
                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-sm btn-success" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">Action<i class="fas fa-caret-down ms-1"></i></button>
                            <div  class="dropdown-menu shadow-lg tx-13">
                                ' . $assignRole . '
                                ' . $assignPermission . '
                                ' . $editbtn . '
                                ' . $deletebtn . '
                            </div>
                        </div>
                    ';
                return $dropdown;
            })
            ->rawColumns(['action', 'roles', 'image', 'permissions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        if (request()->has('user')) {
            return $model->where('type', 0)->where('deleted_at', null)->whereNot('id', 1)->latest()->newQuery();
        } else {
            return $model->where('type', 1)->where('deleted_at', null)->whereNot('id', 1)->latest()->newQuery();
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
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
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
            Column::make('name')->addClass('text-center')->title(__('messages.name')),
            Column::make('phone')->addClass('text-center')->title(__('messages.phone_number')),
            Column::make('email')->addClass('text-center')->title(__('messages.email')),
            Column::make('image')->exportable(false)->addClass('text-center')->title(__('messages.image')),
            Column::make('show_password')->addClass('text-center')->title(__('messages.password')),
            Column::make('roles')->addClass('text-center')->title(__('messages.roles')),
            Column::make('permissions')->addClass('text-center')->title(__('messages.permissions')),
            Column::make('created_at')->addClass('text-center')->title(__('messages.created_at')),
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center')->title(__('messages.action')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Staffs_' . date('YmdHis');
    }
}
