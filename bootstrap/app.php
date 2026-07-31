<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        // Alias Middleware
        $middleware->alias([
            'admin'   => \App\Http\Middleware\AdminMiddleware::class,
            'partner' => \App\Http\Middleware\PartnerMiddleware::class,
        ]);

        // CSRF Exception
        $middleware->validateCsrfTokens(except: [
            '/midtrans/callback',
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function ($response, \Throwable $e) {
            if (getenv('APP_DEBUG') === 'true' || env('APP_DEBUG') === true || config('app.debug')) {
                return response()->json([
                    'error_message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => explode("\n", $e->getTraceAsString()),
                ], 500);
            }
            return $response;
        });
    })
    ->create();

if (is_dir('/tmp')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;