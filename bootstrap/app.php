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
        $exceptions->render(function (\Throwable $e) {
            return response()->make(
                "<div style='font-family:sans-serif;padding:30px;max-width:900px;margin:0 auto;'>" .
                "<h1 style='color:#e53e3e;'>Application Error (500)</h1>" .
                "<h2 style='color:#2d3748;'>" . htmlspecialchars($e->getMessage() ?: get_class($e)) . "</h2>" .
                "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " <strong>Line:</strong> " . $e->getLine() . "</p>" .
                "<h3 style='margin-top:20px;'>Stack Trace:</h3>" .
                "<pre style='background:#edf2f7;padding:15px;border-radius:8px;overflow:auto;font-size:13px;line-height:1.5;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>" .
                "</div>",
                500
            );
        });
    })
    ->create();

if (is_dir('/tmp')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;