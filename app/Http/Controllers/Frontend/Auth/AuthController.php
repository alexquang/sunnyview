<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['confirm', 'logout']);
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return \Inertia::render('Frontend/Auth/Login');
        }

        $credentials = $request->only(['email', 'password']);

        if (\Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->with([
            'iMessage' => \InertiaMessage::error('auth.failed'),
        ]);
    }

    public function confirm(Request $request)
    {
        if ($request->method() == 'GET') {
            return \Inertia::render('Frontend/Auth/LoginConfirm');
        }

        // TODO: confirm
    }

    public function logout(Request $request)
    {
        \Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('frontend.login'));
    }
}
