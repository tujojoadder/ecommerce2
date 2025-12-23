<?php

namespace App\Http\Controllers\User;

use App\Helpers\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $pageTitle = __('messages.profile');
        return view('user.profile.index', compact('pageTitle'));
    }

    public function update(StaffRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->update($request->except('_token', '_method'));
            $user->save();
            // Mail::to($user->email)->send(new UserProfileUpdateMail($user));

            DB::commit();

            alert('Profile Updated!', 'Profile successfully updated!', 'success');
            return redirect()->route('user.profile.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'image' => ['required', 'mimes:png,jpg']
            ], [
                'image.required' => 'Please select an image first.'
            ]);
            $user = User::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($user->image != null) {
                    Storage::disk('profile')->delete($user->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('user-profile')
                    ->upload($photo) ?
                    $user->image = $file->getName() : null;
            }
            $user->save();
            DB::commit();
            toast("Profile Picture Updated Successfully.", "success");
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage(), "Error!");
            return redirect()->back();
        }
    }

    public function changePasswordIndex()
    {
        $pageTitle = __('messages.change') . ' ' . __('messages.password');
        return view('user.profile.index', compact('pageTitle'));
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        if ($request->password) {
            if ($request->current_password != $user->show_password) {
                alert('Password Incorrect!', 'Please enter correct password!', 'warning');
                return redirect()->back();
            }
            if ($request->password == $request->confirm_password) {
                $user->password = Hash::make($request->password);
                $user->show_password = $request->password;
                $user->save();
                toast('Password Changed Successfully!', 'success');
                return redirect()->route('user.profile.index');
            } else {
                alert('Password not match!', 'Please type confirm password same as password!', 'warning');
                return redirect()->back();
            }
        }
    }
}
