<?php

namespace App\Http\Controllers\User;

use App\DataTables\DeleteLogDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteLogController extends Controller
{
    public function deleted(DeleteLogDataTable $dataTable)
    {
        $pageTitle = __('messages.deleted_logs');
        return $dataTable->render('user.logs.deleted', compact('pageTitle'));
    }
}
