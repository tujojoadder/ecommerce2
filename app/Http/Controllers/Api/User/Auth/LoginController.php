<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Add this import

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $username = 'phone';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function sendLoginResponse(Request $request)
    {
        try {
            $this->clearLoginAttempts($request);
            $user = $this->guard()->user();
            if ($response = $this->authenticated($request, $user)) {
                return $response;
            }
            $responseData = [
                'message' => 'Logged in successfully',
                'user' => $user,
            ];

            return $request->wantsJson()
                ? new JsonResponse($responseData, 200)
                : response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 401);
        }
    }

    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 401);
        } catch (\Throwable $th) {
            return response()->json($th, 401);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse(['message' => 'Logged out successfully'], 201)
            : response()->json(['message' => 'Logged out successfully'], 201);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
