<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'unique'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    protected function insertUserData(Request $request)
    {
        try {
            $checkUser = User::where('phone', $request->phone)->count();
            if ($checkUser <= 0) {
                $referBy = User::where('refer_code', $request->refer_code)->first() ?? null;
                $referrer = $referBy->id ?? null;
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'show_password' => $request->input('password'),
                    'username' => Str::lower(str_replace(' ', '', $request->input('name'))) . time(),
                    'phone' => $request->input('phone'),
                    'refer_code' => null,
                    'refer_by' => $referrer ?? null,
                    'type' => 1,
                    'created_by' => $request->input('username'),
                ]);
                $existingAssociation = DB::table('model_has_roles')
                    ->where('role_id', 1)
                    ->where('model_type', 'App\Models\User')
                    ->where('model_id', $user->id)
                    ->first();

                if (!$existingAssociation) {
                    DB::table('model_has_roles')->insert([
                        'role_id' => 1,
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]);
                }
                return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
            } else {
                return response()->json(['error' => 'Phone number already exist!'], 403);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errorInfo[2]], 422);
        }
    }

    protected function create(Request $request)
    {
        try {
            $checkUser = User::where('phone', $request->phone)->count();
            if ($checkUser <= 0) {
                $referBy = User::where('refer_code', $request->refer_code)->first() ?? null;
                $referrer = $referBy->id ?? null;
                $data = $request->all();
                $data['refer_by'] = $referrer;
                $data['refer_code'] = null;
                session()->put(['data' => $data]);
                return response()->json(['data' => $data, 'message' => 'Enter OTP'], 201);
            } else {
                return response()->json(['error' => 'Phone number already exist!'], 403);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errorInfo[2]], 422);
        }
    }

    public function checkUser(Request $request)
    {
        try {
            $data = User::where('refer_code', $request->refer_code)->first() ?? null;
            $message = $data == !null ? 'User Matched!' : 'User Not Found!';
            return response()->json(['message' => $message], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errorInfo[2]], 404);
        }
    }
}
