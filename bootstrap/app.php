<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->name('user.')
                ->group(base_path('routes/user.php'));

            Route::middleware('web')
                ->prefix('ipn')
                ->group(base_path('routes/ipn.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'                  => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'admin.guest'            => \App\Http\Middleware\RedirectIfAdmin::class,
            'check.status'           => \App\Http\Middleware\CheckStatus::class,
            'check.module'           => \App\Http\Middleware\CheckModule::class,
            'registration.complete'  => \App\Http\Middleware\Registration::class,
            'maintenance'            => \App\Http\Middleware\Maintenance::class,
            'checkout.step'          => \App\Http\Middleware\CheckoutStep::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
