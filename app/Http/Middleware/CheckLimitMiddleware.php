<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $packageLimits = [
            'basic' => ['maxClients' => 500, 'maxInvoices' => 500, 'maxProducts' => 200, 'maxStaffs' => 10, 'maxUsers' => 10],
            'professional' => ['maxClients' => 1000, 'maxInvoices' => 1000, 'maxProducts' => 500, 'maxStaffs' => 15, 'maxUsers' => 2],
            'business' => ['maxClients' => PHP_INT_MAX, 'maxInvoices' => PHP_INT_MAX, 'maxProducts' => PHP_INT_MAX, 'maxStaffs' => PHP_INT_MAX, 'maxUsers' => PHP_INT_MAX],
        ];

        $package = siteSettings()->package ?? 'basic';
        $limits = $packageLimits[$package] ?? $packageLimits['basic'];

        $models = [
            'Clients' => Client::count(),
            'Invoices' => Invoice::count(),
            'Products' => Product::count(),
            'Staffs' => User::where('type', 0)->count(),
            'Users' => User::count(),
        ];

        if ($package == 'basic' || $package == 'professional' || $package == 'business') {
            if ($models['Products'] >= $limits['maxProducts'] || $models['Clients'] >= $limits['maxClients'] || $models['Invoices'] >= $limits['maxInvoices'] || $models['Staffs'] >= $limits['maxStaffs'] || $models['Users'] >= $limits['maxUsers']) {
                alert('Package Limit Exceeded!', ucfirst($package) . " limit reached. Cannot add more. Please contact us.", 'warning');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
