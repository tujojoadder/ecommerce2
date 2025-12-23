<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackupLog;

class BackupLogController extends Controller
{
    public function backupLogs()
    {
        $pageTitle = 'Backup Logs';
        $backupLogs = BackupLog::latest()->paginate(50);
        return view('user.dashborad.backup-logs', compact('pageTitle', 'backupLogs'));
    }
}
