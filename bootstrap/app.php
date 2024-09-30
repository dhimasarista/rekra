<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CheckingSession;
use App\Http\Middleware\DataRestriction;
use App\Http\Middleware\PageRedirect;
use App\Http\Middleware\RoleRedirect;
use App\Http\Middleware\UserRoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(DataRestriction::class);
        $middleware->alias([
            "auth" => AuthMiddleware::class,
            "userRole" => UserRoleMiddleware::class,
            "roleRedirect" => RoleRedirect::class,
            "pageRedirect" => PageRedirect::class,
            "dataRestriction" => DataRestriction::class,
            "checkingSession" => CheckingSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
