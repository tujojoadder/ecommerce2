<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $pageTitle = __('messages.roles');
        $roles = Role::where('guard_name', 'web')->where('created_by', Auth::user()->created_by)->orWhere('created_by', null)->paginate(20);
        return view('user.settings.roles.index', compact('pageTitle', 'roles'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => ['required', 'string', 'max:50'],
                'guard_name' => ['required', 'string', 'max:20'],
            ]);
            $role = Role::create($request->all());
            $role->created_by = Auth::user()->username;
            $role->save();
            DB::commit();
            toast('Role added successfully!', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'Superuser') {
            toast('Access Denied!', 'error');
            return redirect()->back();
        }
        $pageTitle = "Editing Role " . $role->name;
        $roles = Role::where('guard_name', 'web')->where('created_by', Auth::user()->created_by)->orWhere('created_by', null)->paginate(20);
        return view('user.settings.roles.index', compact('pageTitle', 'role', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => ['required', 'string', 'max:50'],
                'guard_name' => ['required', 'string', 'max:20'],
            ]);
            Role::findOrFail($id)->update($request->except('_token', '_method'));

            DB::commit();

            toast('Role updated successfully!', 'info');
            return redirect()->route('user.settings.roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        if ($data->name == 'Superuser') {
            toast('Access Denied!', 'error');
            return redirect()->back();
        }
        $data->delete();
        toast('Role deleted successfully!', 'error');
        return response()->json($data);
    }

    public function givePermission($roleId)
    {
        $role = Role::find(($roleId));
        if ($role->name == 'Superuser') {
            toast('Access Denied!', 'error');
            return redirect()->back();
        }
        $pageTitle = "Assigning Permission to " . "(" . $role->name . ")";
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('user.settings.roles.assign-permissions', compact('role', 'permissions', 'pageTitle'));
    }

    public function saveAssignedPermission(Request $request, $roleId)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($roleId);
            if ($role->name == 'Superuser') {
                toast('Access Denied!', 'error');
                return redirect()->back();
            }
            $role->syncPermissions($request->permissions);

            $users = $role->users()->get();
            foreach ($users as $user) {
                $user->syncPermissions($request->permissions);
            }

            DB::commit();

            toast('Permission assigned to ' . "(" . $role->name . ")", 'success');
            return redirect()->route('user.settings.roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}
