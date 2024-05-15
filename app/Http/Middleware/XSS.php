<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSS
{
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            \App::setLocale(\Auth::user()->lang);
        }
        $input = $request->all();
        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });
        $request->merge($input);
        return $next($request);
    }
}
