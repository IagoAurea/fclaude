<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('frontend.url') .'/reset-password?token='.$token;
        });

        Gate::define('viewWebSocketsDashboard', function ($user = null) {
            return config('websockets.show_dashboard');
        });
    }
}
