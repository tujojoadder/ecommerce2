<?php

namespace App\Http\Controllers\User;

use App\Helpers\Traits\BalanceTrait;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use BalanceTrait;
    public function index()
    {
        $pageTitle = __('messages.dashboard');
        $data = [
            'totalInvoice' => Invoice::count(),
            'totalClient' => Client::count(),
            'totalPurchase' => Purchase::count(),
            'totalSupplier' => Supplier::count(),
            'totalUser' => User::where('staff_type', '1')->count(),
            'totalStaff' => User::where('staff_type', '0')->count(),
            'totalReceive' => Transaction::select('amount')->where('type', 'deposit')->sum('amount'),
            'totalExpense' => Transaction::select('amount')->where('type', 'cost')->sum('amount'),
            'totalOrder' => Order::latest()->get(),
        ];
        return view('user.dashborad.index', compact('pageTitle', 'data'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('Staff logout successfully!', 'success');
        return redirect('/login');
    } // End Method
}
