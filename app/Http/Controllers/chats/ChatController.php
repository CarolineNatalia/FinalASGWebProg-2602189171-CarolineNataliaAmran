<?php

namespace App\Http\Controllers\chats;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ChatController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        $friends = auth()->user()->friends->filter(function ($friend) {
            return $friend->friends->contains(auth()->id());
        });
        return view('chats.index', ['friends' => $friends]);
    }

    public function detail($id, $locale = 'en')
    {
        App::setLocale($locale);

        $user = auth()->user();
        $friend = $user->friends->find($id);

        if (!$friend) {
            return redirect()->route('chats', ['locale' => $locale])->with('error', __('alert.friend_not_found'));
        }

        if (!$friend->friends->contains($user->id)) {
            return redirect()->route('chats', ['locale' => $locale])->with('error', __('alert.not_friends'));
        }

        Chat::where('sender_id', $id)
            ->where('receiver_id', $user->id)
            ->where('seen', false)
            ->update(['seen' => true]);

        $chats = Chat::where(function ($query) use ($id, $user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id, $user) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        return view('chats.detail', ['friend' => $friend, 'chats' => $chats]);
    }

    public function send(Request $request, $id, $locale = 'en')
    {
        App::setLocale($locale);

        $friend = auth()->user()->friends->find($id);
        if (!$friend) {
            return redirect()->route('chats', ['locale' => $locale])->with('error', __('alert.friend_not_found'));
        }

        if (!$friend->friends->contains(auth()->id())) {
            return redirect()->route('chats', ['locale' => $locale])->with('error', __('alert.not_friends'));
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', __('alert.message_sent'));
    }
}
