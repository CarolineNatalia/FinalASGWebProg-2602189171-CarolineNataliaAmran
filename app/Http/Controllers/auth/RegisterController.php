<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use App\Models\UserField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RegisterController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        return view('auth.register');
    }

    public function store(Request $request, $locale = 'en')
    {
        App::setLocale($locale);

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'gender' => 'required',
            'linkedin' => 'required|url',
            'phone' => 'required',
            'job' => 'required',
            'cost' => 'required|numeric',
            'name' => 'required',
            'fields' => 'required|array',
        ]);

        $username = explode('/', $request->linkedin);
        $username = end($username);

        $data = [
            'username' => $username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'phone' => $request->phone,
            'job' => $request->job,
            'registration_cost' => $request->cost,
            'name' => $request->name,
        ];

        $user = User::create($data);

        foreach ($request->fields as $field) {
            UserField::create([
                'user_id' => $user->id,
                'field_id' => $field,
            ]);
        }

        auth()->login($user);
        return redirect()->route('auth.pay_registration', ['locale' => $locale])->with('success', __('alert.registration_success'));
    }
}
