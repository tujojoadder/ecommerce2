<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffAttendanceController extends Controller
{
    public function index()
    {
        $pageTitle = __('messages.staff') . ' ' . __('messages.attendance');
        if (request()->ajax()) {
            if (request()->starting_date) {
                $data = Attendance::where('date', request()->starting_date);
            } else if (request()->month && request()->year) {
                $month = request()->input('month');
                $year = request()->input('year');
                $data = Attendance::whereMonth('created_at', $month)->whereYear('created_at', $year);
            } else {
                $data = Attendance::latest();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = $row->staff->image ?? null;
                    return $image !== null ? "<img src=" . asset('storage/profile/' . $image) . " class='rounded-circle' width='30'>" : "<img src=" . asset('dashboard/img/icons/user.png') . " class='rounded-circle' width='30'>";
                })
                ->addColumn('name', function ($row) {
                    return $row->staff->name ?? '--';
                })
                ->addColumn('mobile', function ($row) {
                    return $row->staff->phone ?? '--';
                })
                ->addColumn('date', function ($row) {
                    return date('d M Y', strtotime($row->date));
                })
                ->addColumn('in_time', function ($row) {
                    return date('h:i A', strtotime($row->in_time));
                })
                ->addColumn('out_time', function ($row) {
                    return date('h:i A', strtotime($row->out_time));
                })
                ->addColumn('attendance', function ($row) {
                    if ($row->attendance == 0) {
                        return '<span class="p-1 bg-danger text-white rounded">Absence</span>';
                    } else if ($row->attendance == 1) {
                        return '<span class="p-1 bg-success text-white rounded">Present</span>';
                    } else if ($row->attendance == 2) {
                        return '<span class="p-1 bg-warning text-white rounded">Late</span>';
                    } else {
                        return '<span class="p-1 bg-secondary text-white rounded">Leave</span>';
                    }
                })
                ->addColumn('signature', function ($row) {
                    return '';
                })
                ->rawColumns(['image', 'attendance'])
                ->make(true);
        }
        return view('user.staff.attendance.index', compact('pageTitle'));
    }
    public function monthly()
    {
        $pageTitle = "Monthly Attendance Report";
        if (request()->ajax()) {
            if (request()->staff_id && request()->month && request()->year) {
                $month = request()->input('month');
                $year = request()->input('year');
                $staff_id = request()->input('staff_id');
                $data = Attendance::where('staff_id', $staff_id)->whereMonth('created_at', $month)->whereYear('created_at', $year);
            } else {
                $data = Attendance::latest();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return date('d M Y', strtotime($row->date));
                })
                ->addColumn('in_time', function ($row) {
                    return date('h:i A', strtotime($row->in_time));
                })
                ->addColumn('out_time', function ($row) {
                    return date('h:i A', strtotime($row->out_time));
                })
                ->addColumn('attendance', function ($row) {
                    if ($row->attendance == 0) {
                        return '<span class="px-1 bg-danger text-white rounded">Absence</span>';
                    } else if ($row->attendance == 1) {
                        return '<span class="px-1 bg-success text-white rounded">Present</span>';
                    } else if ($row->attendance == 2) {
                        return '<span class="px-1 bg-warning text-white rounded">Late</span>';
                    } else {
                        return '<span class="px-1 bg-secondary text-white rounded">Leave</span>';
                    }
                })
                ->rawColumns(['attendance'])
                ->make(true);
        }
        return view('user.staff.attendance.monthly', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = "Add Attendance";
        $staffs = User::whereNull('deleted_at')->get();
        return view('user.staff.attendance.create', compact('pageTitle', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $date = $request->input('date');
            $staff_ids = $request->input('staff_id');
            $in_times = $request->input('in_time');
            $out_times = $request->input('out_time');
            $attendances = $request->input('attendance');

            foreach ($staff_ids as $key => $staff_id) {
                $in_time = $in_times[$key];
                $createdBy = Auth::user()->username;
                $createdAt = now();
                $updatedAt = now();

                Attendance::updateOrCreate(
                    ['staff_id' => $staff_id, 'date' => $date],
                    [
                        'in_time' => $in_time,
                        'out_time' => $out_times[$key], // Assuming you have an 'out_time' field
                        'attendance' => $attendances[$key], // Assuming you have an 'attendance' field
                        'created_by' => $createdBy,
                        'created_at' => $createdAt,
                    ]
                )->update(['updated_at' => $updatedAt]);
            }

            DB::commit();

            toastr()->success('Attendance added successfully!');
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
