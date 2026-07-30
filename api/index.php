<?php

// Show all errors for debugging (remove after fixing)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

// Base path of the Laravel application
$basePath = dirname(__DIR__);

// Debug: Check if critical files exist
$criticalFiles = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'config/app.php',
    '.env',
];

$missing = [];
foreach ($criticalFiles as $file) {
    if (!file_exists($basePath . '/' . $file)) {
        $missing[] = $file;
    }
}

if (!empty($missing)) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Missing critical files',
        'basePath' => $basePath,
        'missing' => $missing,
        'dir_contents' => scandir($basePath),
    ]);
    exit(1);
}

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
