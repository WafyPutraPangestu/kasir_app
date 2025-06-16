<?php

use App\Http\Middleware\ChekAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken; // 1. Import class ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Alias middleware Anda tetap di sini
        $middleware->alias([
            'admin' => ChekAdmin::class
        ]);

        // 2. Panggil metode statis `except` dari class VerifyCsrfToken
        VerifyCsrfToken::except([
            'midtrans/callback',
        ]);
        AliasLoader::getInstance()->alias('Cart', Gloudemans\Shoppingcart\Facades\Cart::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
