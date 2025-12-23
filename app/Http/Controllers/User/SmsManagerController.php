<?php

namespace App\Http\Controllers\User;

use App\DataTables\SmsLogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\SmsLog;
use App\Models\Supplier;
use App\Models\SupplierGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsManagerController extends Controller
{
    public function sendToClient()
    {
        $pageTitle = __('messages.send_sms_to_client');
        if (request()->has('client_id')) {
            if (request()->client_id != 'send_to_all') {
                if (request()->url == 'schedule') {
                    $apiResponse = sendSms('client', request()->client_id, 'custom', null, null, request()->message_body);
                    $log = SmsLog::findOrFail(request()->log_id);
                    $log->update(['status' => 1]);
                    toastr()->success('SMS Send successfully!');
                    return redirect()->route('user.sms.schedule.sms.report');
                } else {
                    $apiResponse = sendSms('client', request()->client_id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'client_id' => request()->client_id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                    toastr()->success('SMS Send successfully!');
                    return redirect()->route('user.sms.send.to.client');
                }
            } else {
                $clients = Client::all();
                foreach ($clients as $key => $client) {
                    $apiResponse = sendSms('client', request()->client_id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'client_id' => $client->client_id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                }
                toastr()->success('SMS Send successfully to all clients!');
                return redirect()->route('user.sms.send.to.client');
            }
        }
        return view('user.sms.index', compact('pageTitle'));
    }

    public function sendToClientGroup()
    {
        $pageTitle = __('messages.send_sms_to_client_group');
        if (request()->has('client_group_id')) {
            if (request()->client_group_id != 'send_to_all') {
                $clients = Client::where('group_id', request()->client_group_id)->get();
                foreach ($clients as $key => $client) {
                    $apiResponse = sendSms('client', $client->id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'client_id' => $client->id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                }
                toastr()->success('SMS Send successfully!');
                return redirect()->route('user.sms.send.to.client.group');
            } else {
                $groups = ClientGroup::all();
                foreach ($groups as $key => $group) {
                    $clients = Client::where('group_id', $group->id)->get();

                    foreach ($clients as $key => $client) {
                        $apiResponse = sendSms('client', $client->id, 'custom', null, null, request()->message_body);
                        SmsLog::create([
                            'client_id' => $client->id,
                            'message_body' => request()->message_body,
                            'status' => 1,
                            'created_by' => Auth::user()->username,
                        ]);
                    }
                }
                toastr()->success('SMS Send successfully to all clients!');
                return redirect()->route('user.sms.send.to.client.group');
            }
        }
        return view('user.sms.index', compact('pageTitle'));
    }

    public function sendToSupplier()
    {
        $pageTitle = __('messages.send_sms_to_supplier');
        if (request()->has('supplier_id')) {
            if (request()->supplier_id != 'send_to_all') {
                if (request()->url == 'schedule') {
                    $apiResponse = sendSms('supplier', request()->supplier_id, 'custom', null, null, request()->message_body);
                    $log = SmsLog::findOrFail(request()->log_id);
                    $log->update(['status' => 1]);
                    toastr()->success('SMS Send successfully!');
                    return redirect()->route('user.sms.schedule.sms.report');
                } else {
                    $apiResponse = sendSms('supplier', request()->supplier_id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'supplier_id' => request()->supplier_id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                    toastr()->success('SMS Send successfully!');
                    return redirect()->route('user.sms.send.to.supplier');
                }
            } else {
                $suppliers = Supplier::all();
                foreach ($suppliers as $key => $supplier) {
                    $apiResponse = sendSms('supplier', request()->supplier_id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'supplier_id' => $supplier->supplier_id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                }
                toastr()->success('SMS Send successfully to all suppliers!');
                return redirect()->route('user.sms.send.to.supplier');
            }
        }
        return view('user.sms.index', compact('pageTitle'));
    }

    public function sendToSupplierGroup()
    {
        $pageTitle = __('messages.send_sms_to_supplier_group');
        if (request()->has('supplier_group_id')) {
            if (request()->supplier_group_id != 'send_to_all') {
                $suppliers = Supplier::where('group_id', request()->supplier_group_id)->get();
                foreach ($suppliers as $key => $supplier) {
                    $apiResponse = sendSms('supplier', $supplier->id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'supplier_id' => $supplier->id,
                        'message_body' => request()->message_body,
                        'status' => 1,
                        'created_by' => Auth::user()->username,
                    ]);
                }
                toastr()->success('SMS Send successfully!');
                return redirect()->route('user.sms.send.to.supplier.group');
            } else {
                $groups = SupplierGroup::all();
                foreach ($groups as $key => $group) {
                    $suppliers = Supplier::where('group_id', $group->id)->get();

                    foreach ($suppliers as $key => $supplier) {
                        $apiResponse = sendSms('supplier', $supplier->id, 'custom', null, null, request()->message_body);
                        SmsLog::create([
                            'supplier_id' => $supplier->id,
                            'message_body' => request()->message_body,
                            'status' => 1,
                            'created_by' => Auth::user()->username,
                        ]);
                    }
                }
                toastr()->success('SMS Send successfully to all suppliers!');
                return redirect()->route('user.sms.send.to.supplier.group');
            }
        }
        return view('user.sms.index', compact('pageTitle'));
    }

    public function sendScheduleWise()
    {
        $pageTitle = __('messages.send_sms_schedule_wise');
        if (request()->has('client_id')) {
            if (request()->client_id != 'send_to_all') {
                // $apiResponse = sendSms('client', request()->client_id, 'custom', null, null, request()->message_body);
                SmsLog::create([
                    'client_id' => request()->client_id,
                    'message_body' => request()->message_body,
                    'status' => 0,
                    'schedule_at' => bnToEnDate(request()->schedule_at),
                    'created_by' => Auth::user()->username,
                ]);
                toastr()->success('SMS Send successfully!');
                return redirect()->route('user.sms.send.schedule.wise');
            } else {
                $clients = Client::all();
                foreach ($clients as $key => $client) {
                    // $apiResponse = sendSms('client', request()->client_id, 'custom', null, null, request()->message_body);
                    SmsLog::create([
                        'client_id' => $client->id,
                        'message_body' => request()->message_body,
                        'status' => 0,
                        'schedule_at' => bnToEnDate(request()->schedule_at),
                        'created_by' => Auth::user()->username,
                    ]);
                }
                toastr()->success('SMS Send successfully to all clients!');
                return redirect()->route('user.sms.send.schedule.wise');
            }
        }
        return view('user.sms.index', compact('pageTitle'));
    }

    public function scheduleSmsReport(SmsLogDataTable $dataTable)
    {
        $pageTitle = __('messages.schedule_sms_report');
        return $dataTable->render('user.sms.schedule-report', compact('pageTitle'));
    }
}
