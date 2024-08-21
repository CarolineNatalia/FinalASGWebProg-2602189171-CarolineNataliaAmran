<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LoginController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        return view('auth.login');
    }

    public function store(Request $request, $locale = 'en')
    {
        App::setLocale($locale);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()->with('status', __('alert.invalid_login'));
        }

        return redirect()->route('dashboard', ['locale' => $locale]);
    }

    public function logout($locale = 'en')
    {
        App::setLocale($locale);
        auth()->logout();
        return redirect()->route('auth.login', ['locale' => $locale]);
    }
}
