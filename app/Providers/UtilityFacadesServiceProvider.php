<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class UtilityFacadesServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::bind('utility', function () {
            return new \App\Facades\Utility;
        });
    }

    public function boot()
    {
    }
}
