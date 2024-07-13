<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:[ __DIR__.'/../routes/web.php', __DIR__.'/../routes/admin.php',],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isUser' => \App\Http\Middleware\IsUser::class,
            'hasPrivateClass' => \App\Http\Middleware\HasAvailablePrivateClass::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
