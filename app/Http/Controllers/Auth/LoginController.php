<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            $this->clearLoginAttempts($request);
            return $this->sendLoginResponse($request, $user);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request, $user)
    {
        $request->session()->regenerate();

        $response = $this->authenticated($request, $user);

        if ($request->wantsJson()) {
            return $response ?: new JsonResponse([], 204);
        }

        return $response ?: redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('Lecturer') || $user->hasRole('Student')) {
            return redirect()->route('home.index')->with('success', 'Selamat datang, ' . $user->name . '! Anda telah berhasil login.');
        }

        return redirect()->route('dashboard.index')->with('success', 'Selamat datang, ' . $user->name . '! Anda telah berhasil login.');
    }
}
