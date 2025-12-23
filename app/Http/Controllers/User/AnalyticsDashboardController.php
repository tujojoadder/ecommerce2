<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboardController extends Controller
{
    public function index()
    {
        $pageTitle = 'Analytical Dashboard';
        $invoices = Invoice::where('status', 0)->where('issued_date', '>=', now()->subDays(15))
            ->orderBy('issued_date', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->issued_date)->format('Y-m-d');
            })
            ->map(function ($group, $date) {
                return [
                    'date' => date('d M', strtotime($date)),
                    'amount' => $group->sum('grand_total'),
                ];
            })
            ->values();
        // return $invoices;
        $receives = Transaction::where('type', 'deposit')->where('date', '>=', now()->subDays(15))
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->date)->format('Y-m-d');
            })
            ->map(function ($group, $date) {
                return [
                    'date' => date('d M', strtotime($date)),
                    'amount' => $group->sum('amount'),
                ];
            })
            ->values();

        $expenses = Transaction::whereIn('type', ['cost', 'return'])->where('date', '>=', now()->subDays(15))
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->date)->format('Y-m-d');
            })
            ->map(function ($group, $date) {
                return [
                    'date' => date('d M', strtotime($date)),
                    'amount' => $group->sum('amount'),
                ];
            })
            ->values();
        $dues = $invoices->map(function ($invoice) use ($receives) {
            $receive = $receives->firstWhere('date', $invoice['date']);
            return [
                'date' => $invoice['date'],
                'amount' => $invoice['amount'] - ($receive['amount'] ?? 0),
            ];
        });

        $balances = collect();
        foreach ($receives as $receive) {
            $expense = $expenses->firstWhere('date', $receive['date']);
            $balances->push([
                'date' => $receive['date'],
                'amount' => $receive['amount'] - ($expense['amount'] ?? 0),
            ]);
        }

        $products = InvoiceItem::whereHas('invoice', function ($query) {
            $query->where('status', 0);
        })->when(request()->start_date && request()->end_date, function ($query) {
            $dates = enSearchDate(request()->start_date, request()->end_date);
            $query->whereHas('invoice', function ($query) use ($dates) {
                $query->whereBetween('issued_date', $dates);
            });
        })->orderBy('issued_date', 'desc')
            ->get()
            ->groupBy('product_id') // Group by product
            ->take(30) // Take top 30 products
            ->map(function ($group, $productId) {
                $product = Product::find($productId);
                return [
                    'product' => $product ? $product->name : 'Unknown',
                    'total_quantity' => $group->sum('quantity'),
                    'amount' => $group->sum('quantity') * 100, // Replace with actual price calculation
                ];
            })
            ->values();

        return view('user.dashborad.analytics-dashboard', [
            'pageTitle' => $pageTitle,
            'invoices' => $invoices,
            'receives' => $receives,
            'dues' => $dues,
            'expenses' => $expenses,
            'balances' => $balances,
            'products' => $products,
        ]);
    }
}
