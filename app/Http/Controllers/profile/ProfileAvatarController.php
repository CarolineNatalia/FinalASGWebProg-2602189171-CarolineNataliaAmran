<?php

namespace App\Http\Controllers\profile;

use App\Models\Avatar;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProfileAvatarController
{
    public function index($locale='en'){
        App::setLocale($locale);
        return view('profile.avatar');
    }

    public function use_avatar(Request $request, $locale='en'){
        App::setLocale($locale);
        $request->validate([
            'avatar_id' => 'required|numeric',
        ]);
        $avatar = Avatar::find($request->avatar_id);
        $check = UserAvatar::where('user_id', auth()->id())->where('avatar_id', $avatar->id)->first();
        if(!$check){
            return redirect()->back()->with('error', 'You do not have this avatar');
        }

        if(!auth()->user()->visibility){
            return redirect()->back()->with('error', 'You are not visible to others cannot use avatar, please make yourself visible.');
        }
        auth()->user()->update([
            'picture' => $avatar->image,
        ]);



        return redirect()->route('profile.avatar', ['locale' => $locale])->with('success', 'Avatar used successfully');
    }
}
