<?php

namespace App\Http\Controllers\User\Configuration\PaymentMethod;

use App\DataTables\PaymentMethodDataTable;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\Request;
use App\Helpers\Traits\DeleteLogTrait;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentMethodDataTable $dataTable)
    {
        $pageTitle = __('messages.payment') . ' ' . __('messages.method') . ' ' . __('messages.list');
        return $dataTable->render('user.config.payment-method.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = new PaymentMethod();

            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Payment Method Added Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
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
        $data = PaymentMethod::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMethodRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = PaymentMethod::findOrFail($id);
            $data->name = $request->name;
            $data->created_by = Auth::user()->created_by;
            $data->save();

            DB::commit();

            toast('Payment Method Updated Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $this->deleteLog(PaymentMethod::class, $id);

        toast('Products Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
