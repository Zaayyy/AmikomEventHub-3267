<?php

define('LARAVEL_START', microtime(true));

// Base path of the Laravel application
$basePath = dirname(__DIR__);

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $basePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $basePath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var \Illuminate\Foundation\Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

// Vercel serverless: filesystem is read-only except /tmp
// Override storage paths to use /tmp
$app->useStoragePath('/tmp/storage');

// Ensure required directories exist in /tmp
foreach ([
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

$app->handleRequest(
    Illuminate\Http\Request::capture()
);
