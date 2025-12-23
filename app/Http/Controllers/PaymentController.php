<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SoftwareStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Auth::logout();
        return view('payment.payment');
    }

    public function buyGdrivePackage()
    {
        if (isPurchasedGDBP() >= 1) {
            toast('You have already purchased Google Drive Backup Plus Package!', 'error', 'bottom-right');
            return redirect()->route('user.home');
        }
        $transaction = new Transaction();
        $transaction->type = 'package';
        $transaction->transaction_type = 'backup_package';
        $transaction->account_id = Account::first()->id;
        $transaction->amount = request()->amount;
        $transaction->created_by = 'admin';
        $transaction->save();
    }

    public function manage(Request $reqeust)
    {
        try {
            $baseURL = config('app.api_base_path');
            $software_status = SoftwareStatus::first();
            if ($reqeust->pm == "ssl" and $software_status) {
                $invoice_id = $software_status->invoice_id;
                $url = $baseURL . "/sslc/order?ca_key=$software_status->key&cin_id=$invoice_id";
                return redirect($url);
            }
            return $reqeust->all();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function rechargeSmsBalance()
    {
        if (request()->amount) {
            if (request()->amount < 10) {
                toast('Must have to recharge at least 10 tk or greater!', 'error', 'bottom-right');
                return redirect()->route('recharge.sms.balance');
            }
            $url = config('app.api_base_path') . "/recharge/order?ca_key=" . softwareStatus()->key . "&amount=" . request()->amount;
            return redirect($url);
        }
        $pageTitle = __('messages.recharge_now');
        return view('user.sms.recharge', compact('pageTitle'));
    }
}
