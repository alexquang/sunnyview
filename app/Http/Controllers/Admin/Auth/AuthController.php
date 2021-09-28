<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Request;;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return \Inertia::render('Admin/Auth/Login');
        }

        $credentials = $request->only(['email', 'password']);

        if (\Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with([
            'iMessage' => \InertiaMessage::error('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        \Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
