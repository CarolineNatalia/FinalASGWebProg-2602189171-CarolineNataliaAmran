<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\PayRegistrationController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\avatar\AvatarController;
use App\Http\Controllers\chats\ChatController;
use App\Http\Controllers\coin\CoinController;
use App\Http\Controllers\main\HomeController;
use App\Http\Controllers\profile\ProfileAvatarController;
use App\Http\Controllers\profile\ProfileSettingsController;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isNotLogin;
use App\Http\Middleware\isNotPaid;
use App\Http\Middleware\isPaid;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard/{locale?}', [HomeController::class, 'index'])->name('dashboard')->middleware();

Route::prefix('friends')->group(function () {
    Route::post('/add_friend', [HomeController::class, 'add_friend'])->name('add_friend')->middleware([isLogin::class, isPaid::class]);
    Route::post('/remove_friend', [HomeController::class, 'remove_friend'])->name('remove_friend')->middleware([isLogin::class, isPaid::class]);
    Route::get('/friend_requests/{locale?}', [HomeController::class, 'friend_requests'])->name('friends.friend_requests')->middleware([isLogin::class, isPaid::class]);
});

Route::prefix('profile')->group(function(){
    Route::prefix('avatar')->group(function(){
        Route::get('/{locale?}', [ProfileAvatarController::class, 'index'])->name('profile.avatar')->middleware([isLogin::class, isPaid::class]);
        Route::post('/use_avatar/{locale?}', [ProfileAvatarController::class, 'use_avatar'])->name('profile.avatar.use')->middleware([isLogin::class, isPaid::class]);
    });

    Route::prefix('settings')->group(function(){
        Route::get('/{locale?}', [ProfileSettingsController::class, 'index'])->name('profile.settings')->middleware([isLogin::class, isPaid::class]);
        Route::post('/update/{locale?}', [ProfileSettingsController::class, 'update'])->name('profile.settings.update')->middleware([isLogin::class, isPaid::class]);
        Route::post('/update_password/{locale?}', [ProfileSettingsController::class, 'update_password'])->name('profile.settings.update_password')->middleware([isLogin::class, isPaid::class]);
        Route::post('/update_visibility/{locale?}', [ProfileSettingsController::class, 'update_visibility'])->name('profile.settings.update_visibility');
    });
});

Route::prefix('chats')->group(function () {
    Route::get('/{locale?}', [ChatController::class, 'index'])->name('chats.index')->middleware([isLogin::class, isPaid::class]);
    Route::get('/detail/{id}/{locale?}', [ChatController::class, 'detail'])->name('chats.detail')->middleware([isLogin::class, isPaid::class]);
    Route::post('/send/{id}/{locale?}', [ChatController::class, 'send'])->name('chats.send')->middleware([isLogin::class, isPaid::class]);
});

Route::prefix('avatars')->group(function() {
    Route::get('/{locale?}', [AvatarController::class, 'index'])->name('avatars.index')->middleware([isLogin::class, isPaid::class]);
    Route::post('/{locale?}', [AvatarController::class, 'store'])->name('avatars.store')->middleware([isLogin::class, isPaid::class]);
});

Route::get('/', function () {
    return redirect()->route('auth.register');
});

Route::prefix('coins')->group(function (){
    Route::get('/{locale?}', [CoinController::class, 'index'])->name('coins.index')->middleware([isLogin::class, isPaid::class]);
    Route::post('/topup/{locale?}', [CoinController::class, 'topup'])->name('coins.topup')->middleware([isLogin::class, isPaid::class]);
});
Route::prefix('auth')->group(function () {
    Route::get('/register/{locale?}', [RegisterController::class, 'index'])->name('auth.register')->middleware(isNotLogin::class);
    Route::post('/register/{locale?}', [RegisterController::class, 'store'])->name('auth.register')->middleware(isNotLogin::class);

    Route::get('/login/{locale?}', [LoginController::class, 'index'])->name('auth.login')->middleware(isNotLogin::class);
    Route::post('/login/{locale?}', [LoginController::class, 'store'])->name('auth.login')->middleware(isNotLogin::class);

    Route::get('/pay_registration/{locale?}', [PayRegistrationController::class, 'index'])->name('auth.pay_registration')->middleware([isLogin::class, isNotPaid::class]);
    Route::post('/pay_registration/{locale?}', [PayRegistrationController::class, 'store'])->name('auth.pay_registration')->middleware([isLogin::class, isNotPaid::class]);
    Route::get('/logout/{locale?}', [LoginController::class, 'logout'])->name('auth.logout')->middleware(isLogin::class);
});
