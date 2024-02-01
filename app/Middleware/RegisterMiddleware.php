<?php

namespace Viserlab\Middleware;

class RegisterMiddleware
{
    public $aliasMiddleware = [
        'authorized' => Authorized::class,
        'admin_login' => AdminLogin::class,
        'allow_registration'=>AllowRegistration::class,
        'auth'=>RedirectIfNotLogin::class,
        'checkPlugin'=>RedirectIfNotPluginVerified::class
    ];

    public $globalMiddleware = [
        VerifyNonce::class
    ];
}
