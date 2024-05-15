<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('export-form', function ($user) {
        //     // Logic to determine whether the user can export forms
        //     return $user->hasPermissionTo('export-form'); // Assuming you're using a package like Spatie's laravel-permission
        // });
    }
}
