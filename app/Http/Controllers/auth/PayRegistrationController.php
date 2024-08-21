<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PayRegistrationController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        return view('auth.pay_registration');
    }

    public function store(Request $request, $locale = 'en')
    {
        App::setLocale($locale);

        $request->validate([
            'pay' => 'required|numeric',
        ]);

        if ($request->pay < auth()->user()->registration_cost) {
            $left = auth()->user()->registration_cost - $request->pay;
            return redirect()->back()->with('error', __('alert.registration_underpaid', ['amount' => $left]));
        }

        auth()->user()->update([
            'paid_registration' => true,
            'coins' => auth()->user()->coins + ($request->pay - auth()->user()->registration_cost),
        ]);

        return redirect()->route('dashboard', ['locale' => $locale])->with('success', __('alert.registration_paid'));
    }
}

