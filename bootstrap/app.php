<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\MyMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //$middleware->appendToGroup('web', MyMiddleware::class);
        $middleware->alias([
            'id_mayor_de_10' => MyMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
