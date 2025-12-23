<?php

namespace App\Http\Controllers\User;

use App\DataTables\StaffsDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(StaffsDataTable $dataTable)
    {
        if (request()->has('user')) {
            $pageTitle = __('messages.user') . ' ' .  __('messages.list');
        } else {
            $pageTitle = __('messages.staff') . ' ' . __('messages.list');
        }
        return $dataTable->render('user.staff.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->has('user')) {
            $pageTitle = __('messages.create') . ' ' .  __('messages.user');
        } else {
            $pageTitle = __('messages.staff') . ' ' . __('messages.create');
        }
        return view('user.staff.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        try {
            DB::beginTransaction();

            $type = parse_url($request->headers->get('referer'), PHP_URL_QUERY);
            // Upload staff profile picture
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('user-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload staff profile picture

            $staff = new User($request->all()); // user is also can be staff
            $staff->image = $image; // set image name into staff image field
            if ($request->username == null) {
                $generateUsername = explode('-', Str::slug($request->name)); // slug and exploding
                $username = $generateUsername[0] . date('his'); // generate main username
                $staff->username = $username;
            } else {
                $staff->username = str_replace(' ', '_', $request->username);
                $username = str_replace(' ', '_', $request->username);
            }
            $staff->show_password = $request->password ?? $username;
            $staff->password = Hash::make($request->password ?? $username);
            $staff->created_by = Auth::user()->username;
            $staff->staff_type = $request->staff_type;
            $staff->type = $type == 'user' ? 0 : 1;
            $staff->save();

            DB::commit();

            toast('Staff added successfully!', 'success');
            if ($type) {
                return redirect()->route('user.staff.index', [$type]);
            } else {
                return redirect()->route('user.staff.index');
            }
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
        $pageTitle = __('messages.staff') . ' ' . __('messages.staff');
        $staff = User::findOrFail($id);
        return view('user.staff.create', compact('pageTitle', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            // Upload staff profile picture
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('user-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload staff profile picture

            $staff = User::findOrFail($id);
            $staff->update($request->except('_token', '_method', 'password')); // user is also can be staff

            if ($request->password == !null) {
                $staff->show_password = $request->password;
                $staff->password = Hash::make($request->password);
            } else {
                $staff->show_password = $staff->show_password;
            }

            $staff->username = $staff->username; // set image name into staff image field
            $staff->image = $image; // set image name into staff image field
            $staff->updated_by = Auth::user()->username;
            $staff->staff_type = $request->staff_type ?? $staff->staff_type;
            $staff->save();

            DB::commit();

            toast('Staff updated successfully!', 'success');
            $type = parse_url($request->headers->get('referer'), PHP_URL_QUERY);
            if ($type) {
                return redirect()->route('user.staff.index', [$type]);
            } else {
                return redirect()->route('user.staff.index');
            }
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
        $this->deleteLog(User::class, $id);

        toast('Staff Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }

    public function updateImage(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // return $request->all();
            $this->validate($request, [
                'image' => 'required'
            ], [
                'image.required' => 'Please select an image first.'
            ]);
            $staff = User::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($staff->image != null) {
                    Storage::disk('profile')->delete($staff->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('user-profile')->upload($photo) ? $staff->image = $file->getName() : null;
            }
            $staff->save();

            DB::commit();
            toastr()->success("Profile Picture Updated Successfully.", "Success!");
            return redirect()->route('user.staff.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function assignRole($staffId)
    {
        $staff = User::find(($staffId));
        $pageTitle = "Assigning Role to " . "(" . $staff->name . ")";
        $roles = Role::where('guard_name', 'web')->get();
        return view('user.staff.role-permissions.assign-role', compact('staff', 'roles', 'pageTitle'));
    }

    public function saveAssignedRole(Request $request, $staffId)
    {
        try {
            DB::beginTransaction();
            $staff = User::find($staffId);
            $permissions = [];
            if ($request->role != null) {
                foreach ($request->role as $role) {
                    $singleRole = Role::where('name', $role)->first();
                    foreach ($singleRole->permissions as $permission) {
                        $permissions[] = $permission->name;
                    }
                }
            }
            $staff->syncPermissions($permissions);
            $staff->syncRoles($request->role);

            DB::commit();

            toast('Role assigned to ' . "(" . $staff->name . ")", 'success');
            if ($staff->type == 1) {
                return redirect()->route('user.staff.index', ['user']);
            } else {
                return redirect()->route('user.staff.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function assignPermission($staffId)
    {
        $staff = User::find(($staffId));
        $pageTitle = "Assigning Permission to " . "(" . $staff->name . ")";
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('user.staff.role-permissions.assign-permissions', compact('staff', 'permissions', 'pageTitle'));
    }

    public function saveAssignedPermission(Request $request, $staffId)
    {
        try {
            DB::beginTransaction();
            $staff = User::find($staffId);
            $permissions = $request->permissions ?? [];
            $staff->syncPermissions($permissions);

            DB::commit();

            toast('Role assigned to ' . "(" . $staff->name . ")", 'success');
            if ($staff->type == 1) {
                return redirect()->route('user.staff.index', ['user']);
            } else {
                return redirect()->route('user.staff.index');
            }
            return redirect()->route('user.staff.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
