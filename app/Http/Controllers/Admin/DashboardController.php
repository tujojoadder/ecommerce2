<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = 'Dashboard';
        return view('admin.dashboard.index', compact('pageTitle'));
    }
    public function backupLogs()
    {
        $pageTitle = 'Backup Logs';
        $backupLogs = BackupLog::all();
        return view('admin.dashboard.backup-logs', compact('pageTitle', 'backupLogs'));
    }
}
