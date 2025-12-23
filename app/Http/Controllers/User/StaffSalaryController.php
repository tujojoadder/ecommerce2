<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = "Salary Report";
        if (request()->ajax()) {
            $data = Salary::with('staff')->whereNull('deleted_at')->whereHas('staff', function ($user) {
                return $user->whereNull('deleted_at');
            })->where('month', request()->month)->where('year', request()->year);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = $row->staff->image ?? null;
                    return $image !== null ? "<img src=" . asset('storage/profile/' . $image) . " class='rounded-circle' width='30'>" : "<img src=" . asset('dashboard/img/icons/user.png') . " class='rounded-circle' width='30'>";
                })
                ->addColumn('name', function ($row) {
                    return $row->staff->name ?? '--';
                })
                ->addColumn('payment', function ($row) {
                    return $row->staff->totalPayment($row->staff_id, request()->month, request()->year) ?? '0.00';
                })
                ->addColumn('due', function ($row) {
                    $payment = $row->staff->totalPayment($row->staff_id, request()->month, request()->year) ?? 0;
                    return $row->salary - $payment;
                })
                ->addColumn('status', function ($row) {
                    $payment = $row->staff->totalPayment($row->staff_id, request()->month, request()->year) ?? 0;
                    $due = $row->salary - $payment;
                    if ($row->salary == $due) {
                        return '<span class="p-1 bg-danger text-white rounded">Not Paid</span>';
                    } else if ($row->salary > $due) {
                        return '<span class="p-1 bg-warning text-white rounded">Partially Paid</span>';
                    } else if ($row->salary == $payment) {
                        return '<span class="p-1 bg-success text-white rounded">Paid</span>';
                    } else {
                        return '<span class="p-1 bg-secondary text-white rounded">Undefined</span>';
                    }
                })
                ->addColumn('signature', function ($row) {
                    return '';
                })
                ->rawColumns(['image', 'status'])
                ->make(true);
        }
        return view('user.staff.salary.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = "Add Salary";
        $staffs = User::whereNull('deleted_at')->get();
        return view('user.staff.salary.create', compact('pageTitle', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $month = $request->input('month');
            $year = $request->input('year');
            $staff_ids = $request->input('staff_id');
            $salaries = $request->input('salary');

            foreach ($staff_ids as $key => $staff_id) {
                $salary = $salaries[$key];

                $staff = User::findOrFail($staff_id);
                $staff->salary = $salary;
                $staff->save();

                // Insert or update the salary for the current set of data
                $createdBy = Auth::user()->username;
                $createdAt = now();
                $updatedAt = now();

                Salary::updateOrCreate(
                    ['staff_id' => $staff_id, 'month' => $month, 'year' => $year],
                    ['salary' => $salary, 'created_by' => $createdBy, 'created_at' => $createdAt],
                    ['updated_at' => $updatedAt]
                );
            }

            DB::commit();
            toastr()->success('Salary added successfully!');
            return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
