<?php

use Laravel\Fortify\Features;

return [

    'features' => [
        // Fortifyの機能を有効にする
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirmPassword' => true,
        ]),
    ],

    // 認証ビューの設定
    'views' => [
        'login' => 'auth.login',
        'register' => 'auth.register',
        'reset-password' => 'auth.reset-password',
    ],
];
