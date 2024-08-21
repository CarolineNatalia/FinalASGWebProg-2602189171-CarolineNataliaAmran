<?php

namespace App\Http\Controllers\main;

use App\Models\Field;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);

        $users = User::query();

        // Filter by search query
        if ($search = request('search')) {
            $users = $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        // Filter by field
        if ($field = request('field')) {
            $users = $users->whereHas('fields', function ($query) use ($field) {
                $query->where('field_id', $field);
            });
        }

        // Filter by gender
        if ($gender = request('gender')) {
            $users = $users->where('gender', $gender);
        }

        $users = $users->where('visibility', true)
            ->where('id', '!=', auth()->id())
            ->get();

        $allFields = Field::all(); // Pass all fields for the dropdown

        return view('main.home', [
            'users' => $users,
            'allFields' => $allFields,
        ]);
    }


    public function add_friend(){
        $friend_id = request('friend_id');
        $check = auth()->user()->friends->contains($friend_id);
        if ($check){
            return redirect()->back()->with('error', __('alert.friend_not_found'));
        }

        auth()->user()->friends()->attach($friend_id);
        return redirect()->back()->with('success', __('alert.friend_added'));
    }

    public function remove_friend(){
        $friend_id = request('friend_id');
        $check = auth()->user()->friends->contains($friend_id);
        if (!$check){
            return redirect()->back()->with('error', __('alert.not_friends'));
        }

        auth()->user()->friends()->detach($friend_id);
        return redirect()->back()->with('success', __('alert.friend_removed'));
    }

    public function friend_requests($locale = 'en')
    {
        App::setLocale($locale);
        $currentUserId = auth()->id();
        $currentUserFriendIds = auth()->user()->friends->pluck('id')->toArray();
        $friend_requests = Friend::where('friend_id', $currentUserId)
            ->whereNotIn('user_id', $currentUserFriendIds)
            ->get();

        return view('profile.friend_requests', ['friend_requests' => $friend_requests]);
    }

}
