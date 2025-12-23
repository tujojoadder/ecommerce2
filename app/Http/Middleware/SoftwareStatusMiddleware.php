<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SoftwareStatus as SoftStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SoftwareStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checker = checkSoftwareValidity(); // Getting response from api endpoint
        if ($checker['status'] == 'inactive') {
            Auth::logout();
            return redirect()->route('payment');
        }
        return $next($request);
    }
}
