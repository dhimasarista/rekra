<?php

namespace App\Providers;

use App\Services\MySQLService;
use App\Services\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding UserServiceInterface to UserService
        $this->app->bind(UserServiceInterface::class, UserService::class);

        // Binding MySQLService
        $this->app->bind('MySQLService', function ($app, $params) {
            return new MySQLService($params['table']);
        });

        // Optionally, you could use singleton instead of bind:
        // $this->app->singleton('MySQLService', function ($app, $params) {
        //     return new MySQLService($params['table']);
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
