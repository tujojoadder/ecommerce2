<?php

namespace App\Helpers;

use App\Helpers\Traits\StockTrait;
use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BalanceHelper
{
    use StockTrait;
    public static function getCurrentBalance($balanceModel, $dates = null)
    {
        $totalDeposit = self::getTotalDeposits($balanceModel, $dates);
        $totalExpense = self::getTotalCosts($balanceModel, $dates);
        $totalReturn = self::getTotalMoneyReturn($balanceModel, $dates);

        return $totalDeposit - ($totalExpense);
    }
    public static function getTotalPurchase()
    {
        $purchases = Purchase::where('deleted_at', null)->where('status', 0)->sum('grand_total');
        return $purchases;
    }
    public static function getTotalStockValue()
    {
        $result = DB::selectOne("
            SELECT
            (SELECT SUM(quantity * buying_price) FROM purchase_items) AS total_buying_price,
            (SELECT SUM(buying_price * opening_stock) FROM products) AS product_buying_price,
            (SELECT SUM(quantity * buying_price) FROM invoice_items WHERE status = 0) AS total_selling_price
        ");
        return ($result->total_buying_price + $result->product_buying_price - $result->total_selling_price);
    }
    public static function getTotalSales($dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalSales = InvoiceItem::whereBetween('issued_date', $date)->where('deleted_at', null)->where('status', 0)->select('total')->sum('total'); // total sales
        } else {
            $totalSales = InvoiceItem::where('deleted_at', null)->where('status', 0)->select('total')->sum('total'); // total sales
        }
        return $totalSales;
    }

    public static function getTotalDiscount($dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalSales = Invoice::whereBetween('issued_date', $date)->where('deleted_at', null)->where('status', 0)->select('total_discount')->sum('total_discount'); // total sales
        } else {
            $totalSales = Invoice::where('deleted_at', null)->where('status', 0)->select('total_discount')->sum('total_discount'); // total sales
        }
        return $totalSales;
    }

    public static function getTotalTransportFare($dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalSales = Invoice::whereBetween('issued_date', $date)->where('deleted_at', null)->where('status', 0)->select('transport_fare')->sum('transport_fare'); // total sales
        } else {
            $totalSales = Invoice::where('deleted_at', null)->where('status', 0)->select('transport_fare')->sum('transport_fare'); // total sales
        }
        return $totalSales;
    }

    public static function getTotalVat($dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalSales = Invoice::whereBetween('issued_date', $date)->where('deleted_at', null)->where('status', 0)->select('total_vat')->sum('total_vat'); // total sales
        } else {
            $totalSales = Invoice::where('deleted_at', null)->where('status', 0)->select('total_vat')->sum('total_vat'); // total sales
        }
        return $totalSales;
    }

    public static function getTotalProfit($dates = null)
    {
        // Build the base query
        $query = Transaction::whereNotIn('transaction_type', ['account', 'deposit'])
            ->where('type', 'deposit')
            ->whereNull('deleted_at')
            ->with(['invoice.invoiceItems']); // Eager load invoice and invoiceItems

        if ($dates != null) {
            $query->whereBetween('date', [$dates]);
        }

        $buyingPrice = 0;
        $sellingPrice = 0;

        // Use chunk to process data in smaller batches
        $query->chunk(100, function ($transactions) use (&$buyingPrice, &$sellingPrice) {
            foreach ($transactions as $row) {
                foreach ($row->invoice->invoiceItems ?? [] as $item) {
                    $buyingPrice += $item->buying_price * $item->quantity;
                    $sellingPrice += $item->selling_price * $item->quantity;
                }
            }
        });

        // Calculate and return the total profit
        $profit = $sellingPrice - $buyingPrice;
        return $profit;
    }
    public static function getTotalBuyPrice($invoiceModel, $dates = null)
    {
        $totalBuyingPrice = 0;

        $query = $invoiceModel::where('invoices.status', 0)
            ->whereNull('invoices.deleted_at')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->selectRaw('SUM(invoice_items.quantity * invoice_items.buying_price) as total_buying_price')
            ->groupBy('invoices.id');

        // Apply date range filter if provided
        if ($dates !== null) {
            $query->whereBetween('invoices.issued_date', $dates);
        }

        // Use chunking to process results in batches
        $query->chunk(1000, function ($invoices) use (&$totalBuyingPrice) {
            foreach ($invoices as $invoice) {
                $totalBuyingPrice += $invoice->total_buying_price;
            }
        });

        return $totalBuyingPrice;
    }
    public static function getTotalDeposits($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalDeposit = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->whereNotIn('transaction_type', ['account', 'transfer'])->where('type', 'deposit')->sum('amount'); // total receives
        } else {
            $totalDeposit = $balanceModel::select('amount')->where('deleted_at', null)->whereNotIn('transaction_type', ['account', 'transfer'])->where('type', 'deposit')->sum('amount'); // total receives
        }
        return $totalDeposit;
    }
    public static function getTotalAdjustments($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalDeposit = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->where('transaction_type', 'adjustment')->where('type', 'deposit')->sum('amount'); // total receives
        } else {
            $totalDeposit = $balanceModel::select('amount')->where('deleted_at', null)->where('transaction_type', 'adjustment')->where('type', 'deposit')->sum('amount'); // total receives
        }
        return $totalDeposit;
    }
    public static function getTotalCosts($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->whereIn('type', ['cost', 'return'])->whereNotIn('transaction_type', ['transfer'])->sum('amount'); // total cost
        } else {
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereIn('type', ['cost', 'return'])->whereNotIn('transaction_type', ['transfer'])->sum('amount'); // total cost
        }
        return $totalCost;
    }

    public static function totalInvoiceDue($date = null)
    {
        $totalDue = 0;
        Invoice::chunk(100, function ($invoices) use (&$totalDue) {
            foreach ($invoices as $invoice) {
                $invoiceDue = self::getInvoiceTotalDue(Transaction::class, $invoice->id);
                if ($invoiceDue >= 0) {
                    $totalDue += abs($invoiceDue);
                }
            }
        });
        return numberFormat($totalDue, 2);
    }

    public static function getInvoiceTotalDue($balanceModel, $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $totalDue = $invoice->grand_total - $balanceModel::where('invoice_id', $invoice_id)->sum('amount');
        return $totalDue;
    }

    public static function getTotalOfficeExpense($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->where('type', 'cost')->where('expense_type', 'office_expense')->sum('amount'); // total office expense
            // $invoices = Invoice::whereBetween('issued_date', [$date]);
            // $transport_fare = $invoices->sum('transport_fare');
            // $labour_cost = $invoices->sum('labour_cost');
        } else {
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->where('type', 'cost')->where('expense_type', 'office_expense')->sum('amount'); // total office expense
            // $invoices = Invoice::all();
            // $transport_fare = $invoices->sum('transport_fare');
            // $labour_cost = $invoices->sum('labour_cost');
        }
        return $totalCost; // + $transport_fare + $labour_cost;
    }

    public static function getTotalPersonalCosts($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->where('transaction_type', 'personal_expense')->sum('amount'); // total cost
        } else {
            $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->where('transaction_type', 'personal_expense')->sum('amount'); // total cost
        }
        return $totalCost;
    }
    public static function getTotalMoneyReturn($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            return $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->where('type', 'return')->where('transaction_type', 'money_return')->sum('amount'); // total receives
        } else {
            return $balanceModel::select('amount')->where('deleted_at', null)->where('type', 'return')->where('transaction_type', 'money_return')->sum('amount'); // total receives
        }
    }
    public static function getTotalTransfer($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            return $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', $date)->where('type', 'cost')->where('transaction_type', 'transfer')->sum('amount'); // total transfer
        } else {
            return $balanceModel::select('amount')->where('deleted_at', null)->where('type', 'cost')->where('transaction_type', 'transfer')->sum('amount'); // total transfer
        }
    }
    public static function getSalesReturn($invoiceModel, $dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            return $invoiceModel::whereBetween('date', $date)->where('status', 4)->where('deleted_at', null)->select('grand_total')->sum('grand_total');
        } else {
            return $invoiceModel::where('status', 4)->where('deleted_at', null)->select('grand_total')->sum('grand_total');
        }
    }
    public static function getTotalPreviousDue($dates = null)
    {
        if ($dates == !null) {
            $date = [$dates];
            return Client::whereBetween('created_at', $date)->select('previous_due')->sum('previous_due');
        } else {
            return Client::select('previous_due')->sum('previous_due');
        }
    }
    public static function getTotalDue($balanceModel, $dates = null)
    {
        if ($dates == !null) {
            $created_at = [$dates];
            $previousDue = Client::where('deleted_at', null)->where('type', 0)->whereBetween('created_at', $created_at)->sum('previous_due');

            $netSales = self::getTotalSales($dates);

            $moneyReturn = self::getTotalMoneyReturn($balanceModel, $dates);
            $deposit = self::getTotalDeposits($balanceModel, $dates);
            $netDeposit = $deposit - $moneyReturn;

            $extra = self::getTotalVat($dates) + self::getTotalTransportFare();
            $discount = self::getTotalDiscount();
            $due = ($netSales - $netDeposit) + $previousDue - $extra;
            return $due;
        } else {
            $previousDue = Client::sum('previous_due');
            $netSales = self::getTotalSales();

            $moneyReturn = self::getTotalMoneyReturn($balanceModel);
            $deposit = self::getTotalDeposits($balanceModel);
            $netDeposit = $deposit - $moneyReturn;

            $extra = self::getTotalVat() + self::getTotalTransportFare();
            $discount = self::getTotalDiscount();
            $due = ($netSales - $netDeposit) + $previousDue - $extra;
            return $due;
        }
    }
    // Today Calculation -------------------------------------------------------------------------------------------------------------------------------------------------------------
    public static function getTodayBalance($balanceModel)
    {
        $totalReceives = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->where('type', 'deposit')->whereNot('transaction_type', 'adjustment')->sum('amount'); // total receives
        $totalExpenses = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->where('type', 'cost')->sum('amount'); // total receives
        $totalReturns = $balanceModel::select('amount')->where('deleted_at', null)->where('transaction_type', 'money_return')->whereDate('date', Carbon::today())->where('type', 'return')->sum('amount'); // total receives
        // return $totalReceives - $totalExpenses;
        return $totalReceives - ($totalExpenses + $totalReturns);
    }
    public static function getTodaySales($balanceModel)
    {
        $totalSales = $balanceModel::where('status', 0)->select('grand_total')->whereDate('issued_date', Carbon::today())->sum('grand_total'); // total sales
        $totalSalesReturn = $balanceModel::where('status', 4)->select('grand_total')->whereDate('issued_date', Carbon::today())->sum('grand_total'); // total sales
        return $totalSales;
    }
    public static function getTodayDeposits($balanceModel)
    {
        $totalDeposit = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->whereNotIn('transaction_type', ['account', 'adjustment', 'transfer'])->where('type', 'deposit')->sum('amount'); // total receives
        return $totalDeposit;
    }
    public static function getTodayAdjustments($balanceModel)
    {
        $todayAdjustments = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->where('transaction_type', 'adjustment')->where('type', 'deposit')->sum('amount'); // total receives
        return $todayAdjustments;
    }
    public static function getTodayCosts($balanceModel)
    {
        $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->whereIn('type', ['cost', 'return'])->whereNot('transaction_type', 'transfer')->sum('amount'); // total receives
        return $totalCost;
    }
    public static function getTodayReturn($balanceModel)
    {
        $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereDate('date', Carbon::today())->where('type', 'return')->sum('amount'); // total receives
        return $totalCost;
    }

    public static function getTodayMoneyReturn($balanceModel)
    {
        return $balanceModel::select('amount')->where('deleted_at', null)->where('type', 'return')->where('transaction_type', 'money_return')->whereDate('date', Carbon::today())->sum('amount'); // total receives
    }
    public static function getTodaySalesReturn($invoiceModel)
    {
        return $invoiceModel::where('status', 4)->select('grand_total')->whereDate('issued_date', Carbon::today())->sum('grand_total');
    }
    public static function getTodayDue($balanceModel)
    {
        $previousDue = Client::whereDate('created_at', Carbon::today())->sum('previous_due');
        $sales = self::getTodaySales(Invoice::class);
        // $salesReturn = self::getTodaySalesReturn(Invoice::class);
        $netSales = $sales;

        $moneyReturn = self::getTodayMoneyReturn($balanceModel);
        $deposit = self::getTodayDeposits($balanceModel);
        $netDeposit = $deposit - $moneyReturn;

        $due = ($netSales - $netDeposit) + $previousDue;
        if ($netSales < $netDeposit) {
            return 0;
        } else {
            return $due;
        }
    }
    // Previous Month Calculations --------------------------------------------------------------------------------------------------------------------------------------------------
    public static function getMonthlyBalance($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $totalReceives = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->where('type', 'deposit')->whereNot('transaction_type', 'adjustment')->sum('amount'); // total receives
        $totalExpenses = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->where('type', 'cost')->sum('amount'); // total receives
        $totalReturns = $balanceModel::select('amount')->where('deleted_at', null)->where('transaction_type', 'money_return')->whereBetween('date', [$dates['first_date'], $dates['last_date']])->where('type', 'return')->sum('amount'); // total receives
        // return $totalReceives - $totalExpenses;
        return $totalReceives - ($totalExpenses + $totalReturns);
    }
    public static function getMonthlySales($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $totalSales = $balanceModel::where('status', 0)->whereBetween('issued_date', [$dates['first_date'], $dates['last_date']])->select('grand_total')->sum('grand_total'); // total sales
        $totalSalesReturn = $balanceModel::where('status', 4)->whereBetween('issued_date', [$dates['first_date'], $dates['last_date']])->select('grand_total')->sum('grand_total'); // total sales
        return $totalSales;
    }
    public static function getMonthlyDeposits($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $monthlyDeposit = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->whereNotIn('transaction_type', ['account', 'adjustment', 'transfer'])->where('type', 'deposit')->sum('amount'); // total receives
        return $monthlyDeposit;
    }
    public static function getMonthlyAdjustments($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $monthlyAdjustment = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->where('transaction_type', 'adjustment')->where('type', 'deposit')->sum('amount'); // total receives
        return $monthlyAdjustment;
    }
    public static function getMonthlyCosts($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->whereIn('type', ['cost', 'return'])->whereNot('transaction_type', 'transfer')->sum('amount'); // total receives
        return $totalCost;
    }
    public static function getMonthlyReturn($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $totalCost = $balanceModel::select('amount')->where('deleted_at', null)->whereBetween('date', [$dates['first_date'], $dates['last_date']])->where('type', 'return')->sum('amount'); // total receives
        return $totalCost;
    }
    public static function getMonthlyMoneyReturn($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        return $balanceModel::select('amount')->where('deleted_at', null)->where('type', 'return')->where('transaction_type', 'money_return')->whereBetween('date', [$dates['first_date'], $dates['last_date']])->sum('amount'); // total receives
    }
    public static function getMonthlySalesReturn($invoiceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        return $invoiceModel::where('status', 4)->where('deleted_at', null)->select('grand_total')->whereBetween('issued_date', [$dates['first_date'], $dates['last_date']])->sum('grand_total');
    }
    public static function getMonthlyDue($balanceModel)
    {
        $dates = self::currentMonth(Carbon::now());
        $previousDue = Client::where('deleted_at', null)->whereBetween('created_at', [$dates['first_date'], $dates['last_date']])->sum('previous_due');
        $sales = self::getMonthlySales(Invoice::class);
        // $salesReturn = self::getMonthlySalesReturn(Invoice::class);
        $netSales = $sales;

        $moneyReturn = self::getMonthlyMoneyReturn($balanceModel);
        $deposit = self::getMonthlyDeposits($balanceModel);
        $netDeposit = $deposit - $moneyReturn;

        $due = ($netSales - $netDeposit) + $previousDue;
        return $due;
    }
    // Previous Month Method --------------------------------------------------------------------------------------------------------------------------------------------------
    public static function currentMonth($currentDate)
    {
        $currentMonth = $currentDate->copy();
        $firstDate = $currentMonth->firstOfMonth();
        $lastDate = $currentDate->endOfMonth();

        $dates['first_date'] = $firstDate;
        $dates['last_date'] = $lastDate;

        return $dates;
    }

    // Total Balance Report Module
    public static function selfInvestment()
    {
        $totalPurchase = Account::select('initial_balance')->whereNull('deleted_at')->sum('initial_balance');
        return numberFormat($totalPurchase, 2);
    }

    public static function totalSupplierPurchase()
    {
        $totalPurchase = Purchase::select('grand_total')->where('status', 0)->whereNull('deleted_at')->sum('grand_total');
        return numberFormat($totalPurchase, 2);
    }

    public static function totalSupplierPayment()
    {
        $totalPayment = Transaction::select('amount')->whereIn('transaction_type', ['purchase', 'supplier_payment'])->sum('amount');
        return numberFormat($totalPayment, 2);
    }

    public static function totalSupplierDue()
    {
        $totalPurchase = self::totalSupplierPurchase();
        $totalPayment = self::totalSupplierPayment();
        return numberFormat($totalPurchase - $totalPayment, 2);
    }

    public static function totalLoanAmount()
    {
        $totalLoanPayment = Transaction::select('amount')->whereIn('transaction_type', ['loan_payment'])->sum('amount');
        $totalLoanReceive = Transaction::select('amount')->whereIn('transaction_type', ['loan_receive'])->sum('amount');
        $totalLoan = $totalLoanPayment - $totalLoanReceive;
        return numberFormat($totalLoan, 2);
    }

    public static function totalClientAdvance()
    {
        $clients = Client::all();
        $previousDue = $clients->select('previous_due')->sum('previous_due');

        $totalAdvance = 0;
        foreach ($clients as $client) {
            $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $client->id);
            if ($clientDue < 0) {
                $totalAdvance += abs($clientDue);
            }
        }
        return numberFormat($totalAdvance, 2);
    }

    public static function totalClientDue()
    {
        $clients = Client::all();
        $previousDue = $clients->select('previous_due')->sum('previous_due');

        $totalDue = 0;
        foreach ($clients as $client) {
            $clientDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $client->id);
            if ($clientDue >= 0) {
                $totalDue += abs($clientDue);
            }
        }
        return numberFormat($totalDue, 2);
    }

    public static function totalRunningCapital()
    {
        $investment = self::selfInvestment();
        $supplierDue = self::totalSupplierDue();
        $stockValue = getStockValue();
        $totalLoan = self::totalLoanAmount();
        $clientAdvance = self::totalClientAdvance();
        $totalRunningCapital = array_sum([$investment, $supplierDue, $stockValue, $totalLoan, $clientAdvance]);
        return numberFormat($totalRunningCapital, 2);
    }
}
