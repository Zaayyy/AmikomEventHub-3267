<?php

// Show all errors for debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

$basePath = dirname(__DIR__);

// Ensure /tmp directories for Vercel Serverless
$storagePath = '/tmp/storage';
foreach ([
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
    $storagePath . '/app/public',
] as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Setup SQLite in /tmp if using sqlite
$dbFile = '/tmp/database.sqlite';
$isNewDb = !file_exists($dbFile);
if ($isNewDb) {
    @touch($dbFile);
}
putenv("DB_DATABASE={$dbFile}");
$_ENV['DB_DATABASE'] = $dbFile;
$_SERVER['DB_DATABASE'] = $dbFile;

try {
    // Autoload
    require_once $basePath . '/vendor/autoload.php';

    // Bootstrap Laravel
    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once $basePath . '/bootstrap/app.php';

    // Override storage path to /tmp/storage
    $app->useStoragePath($storagePath);

    // Register essential providers
    $app->register(\Illuminate\View\ViewServiceProvider::class);

    // If new SQLite DB, auto-run migrations and seeders
    if ($isNewDb) {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
                '--force' => true,
                '--seed' => true,
            ]);
        } catch (\Throwable $migrationError) {
            // Ignore migration error if already ran or continue
        }
    }

    // Handle Request
    $request = Illuminate\Http\Request::capture();
    $response = $app->handleRequest($request);
    $response->send();
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "SERVERLESS BOOTSTRAP ERROR:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString();
    exit(1);
}



