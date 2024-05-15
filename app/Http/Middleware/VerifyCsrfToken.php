<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'forms/fill/*',
        '/paytm-callback*',
        // '/payumoney/fill/prepare*',
        // 'payumoney-fill-payment/*',
    ];
}
