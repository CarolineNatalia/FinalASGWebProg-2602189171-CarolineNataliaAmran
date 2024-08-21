<?php

namespace App\Http\Controllers\avatar;

use App\Models\Avatar;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AvatarController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        $avatars = Avatar::all();
        return view('avatar.index', ['avatars' => $avatars]);
    }

    public function store(Request $request, $locale = 'en')
    {
        App::setLocale($locale);

        $request->validate([
            'avatar_id' => 'required|numeric',
        ]);

        $avatar = Avatar::find($request->avatar_id);
        if (auth()->user()->coins < $avatar->price) {
            return redirect()->back()->with('error', __('alert.not_enough_coins'));
        }

        auth()->user()->update([
            'coins' => auth()->user()->coins - $avatar->price,
        ]);

        $check = UserAvatar::where('user_id', auth()->id())->where('avatar_id', $avatar->id)->first();
        if ($check) {
            return redirect()->back()->with('error', __('alert.avatar_already_owned'));
        }

        UserAvatar::create([
            'user_id' => auth()->id(),
            'avatar_id' => $avatar->id,
        ]);

        return redirect()->route('avatars.index', ['locale' => $locale])->with('success', __('alert.avatar_purchased'));
    }
}

