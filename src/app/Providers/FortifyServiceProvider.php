<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Http\Responses\SimpleViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ログインビューの設定
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 登録ビューの設定
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // app()->singleton(LoginViewResponse::class, function () {
        //     return new SimpleViewResponse(view('auth.login'));
        // });
    }
}
