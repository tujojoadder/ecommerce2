<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrafficLog;
use Illuminate\Http\Request;

class ServerInfoController extends Controller
{
    public function index()
    {
        $directory = base_path();
        $totalSize = getDirSize($directory, [base_path('vendor'), base_path('node_modules'), base_path('storage')]);
        $totalDirSize = getDirSize($directory, []) / 1024 / 1024;

        $currentMemoryUsage = memory_get_usage();
        $peakMemoryUsage = memory_get_peak_usage();
        $currentMemoryUsageMB = $currentMemoryUsage / 1024 / 1024;
        $peakMemoryUsageMB = $peakMemoryUsage / 1024 / 1024;

        $bandwithUsageMonthly = TrafficLog::bandwidthUsageLastMonth();
        $bandwithUsageDaily = TrafficLog::bandwidthUsageToday();
        $serverInfo = [
            'PHP Version' => PHP_VERSION,
            'Laravel Version' => app()->version(),
            'Total File Size' => numberFormat($totalDirSize, 2) . ' MB',
            'Current Memory Usage' => numberFormat($currentMemoryUsageMB, 2) . ' MB',
            'Peak Memory Usage' => numberFormat($peakMemoryUsageMB, 2) . ' MB',
            'Bandwidth Usage Today' => numberFormat($bandwithUsageMonthly, 2) . ' MB',
            'Bandwidth Usage This Month' => numberFormat($bandwithUsageMonthly, 2) . ' MB',
        ];
        if (request()->ajax()) {
            return response()->json($serverInfo);
        }
        // return $serverInfo;
        $pageTitle = __('messages.server_info');
        return view('user.settings.info', compact('pageTitle'));
    }
}
