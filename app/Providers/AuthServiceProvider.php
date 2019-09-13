<?php

namespace App\Providers;

use App\Components\JWT\JWTGenerate;
use App\Components\JWT\JWTGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register the JWT Guard
        Auth::extend('jwt', function ($app, $name, array $config) {
            return new JWTGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });
    }
}
