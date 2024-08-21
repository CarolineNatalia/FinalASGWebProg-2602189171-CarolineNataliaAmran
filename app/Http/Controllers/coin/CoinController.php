<?php

namespace App\Http\Controllers\coin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CoinController
{
    public function index($locale = 'en')
    {
        App::setLocale($locale);
        return view('coin.index');
    }

    public function topup(Request $request, $locale = 'en')
    {
        App::setLocale($locale);

        $request->validate([
            'amount' => 'required|numeric',
        ]);

        auth()->user()->update([
            'coins' => auth()->user()->coins + $request->amount,
        ]);

        return redirect()->route('coins.index', ['locale' => $locale])->with('success', __('alert.coins_added'));
    }
}
