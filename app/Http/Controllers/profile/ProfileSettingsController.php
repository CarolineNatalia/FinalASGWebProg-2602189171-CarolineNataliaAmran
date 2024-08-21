<?php

namespace App\Http\Controllers\profile;

use App\Models\UserField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileSettingsController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        return view('profile.settings');
    }

    public function update(Request $request, $locale = 'en')
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'job' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'fields' => 'array',
            'fields.*' => 'exists:fields,id',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->job = $request->input('job');
        $user->username = $request->input('username');
        $user->save();

        UserField::where('user_id', $user->id)->delete();

        if ($request->has('fields')) {
            foreach ($request->input('fields') as $fieldId) {
                UserField::create([
                    'user_id' => $user->id,
                    'field_id' => $fieldId,
                ]);
            }
        }

        return redirect()->route('profile.settings', ['locale' => $locale])
            ->with('success', 'Profile updated successfully.');
    }

    public function update_password(Request $request, $locale = 'en')
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validation rules
        $rules = [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the current password matches the stored password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()
                ->with('error', 'The current password is incorrect.');
        }

        // Update the user's password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        // Redirect with a success message
        return redirect()->route('profile.settings', ['locale' => $locale])
            ->with('success', 'Password updated successfully.');
    }

    public function update_visibility(Request $request, $locale = 'en')
    {
        // dd($request->all());
        $user = auth()->user();

        $visibility = $request->has('visibility');

        if (!$visibility) {

            if ($user->visibility == false) {
                return redirect()->back()
                    ->with('error', 'Your profile is already private.');
            }

            if ($user->coins < 50) {
                return redirect()->back()
                    ->with('error', 'You do not have enough coins to make your profile private.');
            }
            $user->coins -= 50;
            $user->visibility = false;
            $user->picture_before_invisible = $user->picture;
            $user->picture = 'bear' . rand(1, 3) . '.jpg';
        } else {
            if ($user->visibility == true) {
                return redirect()->back()
                    ->with('error', 'Your profile is already public.');
            }
            if ($user->coins < 5) {
                return redirect()->back()
                    ->with('error', 'You do not have enough coins to make your profile public.');
            }
            $user->coins -= 5;
            $user->visibility = true;
            $user->picture = $user->picture_before_invisible;
        }

        $user->save();

        return redirect()->route('profile.settings', ['locale' => $locale])
            ->with('success', 'Profile visibility updated successfully.');
    }
}
