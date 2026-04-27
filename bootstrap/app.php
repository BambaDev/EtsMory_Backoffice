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
                ->prefix('user')
                ->name('user.')
                ->group(base_path('routes/user.php'));

            Route::middleware('web')
                ->prefix('ipn')
                ->group(base_path('routes/ipn.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('user.login'));

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\LanguageMiddleware::class,
            \App\Http\Middleware\ActiveTemplateMiddleware::class,
        ]);

        $middleware->alias([
            'admin'                  => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'admin.guest'            => \App\Http\Middleware\RedirectIfAdmin::class,
            'check.status'           => \App\Http\Middleware\CheckStatus::class,
            'checkModule'            => \App\Http\Middleware\CheckModuleIsEnabled::class,
            'registration.complete'  => \App\Http\Middleware\RegistrationStep::class,
            'maintenance'            => \App\Http\Middleware\MaintenanceMode::class,
            'checkout.step'          => \App\Http\Middleware\CheckoutStepMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
