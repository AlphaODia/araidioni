<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        // Enregistrement du provider Firebase
        Auth::provider('firebase', function ($app, array $config) {
            return new \App\Auth\FirebaseUserProvider();
        });
    }
}