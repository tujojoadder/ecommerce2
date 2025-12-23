<?php

namespace App\Http\Controllers\User;

use App\DataTables\ChequeScheduleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ChequeSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeSchuduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChequeScheduleDataTable $dataTable)
    {
        $pageTitle = __('messages.supplier') . ' ' . __('messages.cheque_schedule');
        return $dataTable->render('user.supplier.cheque-schedule.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.supplier') . '' . __('messages.create');
        return view('user.supplier.cheque-schedule.form', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'date' => 'required',
        ]);


        $data = new ChequeSchedule($request->all());
        $data->created_by = Auth::user()->created_by;
        $data->date = bnToEnDate($request->date);
        $data->save();

        toast('Supplier Checque Schedule Added Successfully!', 'success', 'bottom-right');
        return redirect()->route('user.cheque.schudule.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = __('message.edit');
        $data = ChequeSchedule::findOrFail($id);
        return view('user.supplier.cheque-schedule.form', compact('pageTitle', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'date' => 'required',
        ]);

        $date = str_replace('/', '-', $request->date);

        $data = ChequeSchedule::findOrFail($id);
        $data->supplier_id = $request->supplier_id;
        $data->bank_name = $request->bank_name;
        $data->cheque_no = $request->cheque_no;
        $data->amount = $request->amount;
        $data->created_by = Auth::user()->created_by;
        $data->date = Carbon::parse($date)->format('Y-m-d');
        $data->save();

        toast('Supplier updated Successfully!', 'success', 'bottom-right');
        return redirect()->route('user.cheque.schudule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        ChequeSchedule::findOrFail($id)->delete();
        return response()->json();
    }
}
