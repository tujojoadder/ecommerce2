<?php

namespace App\Http\Middleware;

use App\Models\TrafficLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrafficMonitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestData = $request->except([
            'files',
            'image',
            'file',
            'bulk_file',
            'bulk_parent_file',
            'invoice_header',
            'banner',
            'logo',
            'slider',
            'subimage',
            'banner',
            'banner2',
            'icon',
            'favicon'
        ]);
        $requestSize = strlen(serialize($requestData));

        // Proceed with the request and get the response
        $response = $next($request);

        // Get the size of the response
        $responseSize = strlen($response->getContent());

        // Calculate total traffic in bytes
        $totalTraffic = $requestSize + $responseSize;

        try {
            // Log the traffic usage to the TrafficLog table
            TrafficLog::create([
                'ip_address' => $request->ip(),
                'request_size' => $requestSize,
                'response_size' => $responseSize,
                'total_traffic' => $totalTraffic,
                'created_by' => Auth::check() ? Auth::user()->username : 'guest',
            ]);
        } catch (\Throwable $th) {
        }
        return $response;
    }
}
