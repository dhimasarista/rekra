<?php

namespace App\Providers;

use App\Services\MySQLService;
use Illuminate\Support\ServiceProvider;

class MySQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         // Binding MySQLService as a singleton
        $this->app->singleton('MySQLService', function ($app, $params) {
            return new MySQLService($params['table']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
