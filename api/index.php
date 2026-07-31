<?php

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

putenv("APP_STORAGE_PATH={$storagePath}");
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
putenv("APP_PACKAGES_CACHE={$storagePath}/packages.php");
putenv("APP_SERVICES_CACHE={$storagePath}/services.php");
putenv("APP_ROUTES_CACHE={$storagePath}/routes.php");
putenv("APP_EVENTS_CACHE={$storagePath}/events.php");

$_ENV['APP_STORAGE_PATH'] = $storagePath;
$_ENV['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";
$_ENV['APP_PACKAGES_CACHE'] = "{$storagePath}/packages.php";
$_ENV['APP_SERVICES_CACHE'] = "{$storagePath}/services.php";
$_ENV['APP_ROUTES_CACHE'] = "{$storagePath}/routes.php";
$_ENV['APP_EVENTS_CACHE'] = "{$storagePath}/events.php";

$_SERVER['APP_STORAGE_PATH'] = $storagePath;
$_SERVER['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";
$_SERVER['APP_PACKAGES_CACHE'] = "{$storagePath}/packages.php";
$_SERVER['APP_SERVICES_CACHE'] = "{$storagePath}/services.php";
$_SERVER['APP_ROUTES_CACHE'] = "{$storagePath}/routes.php";
$_SERVER['APP_EVENTS_CACHE'] = "{$storagePath}/events.php";

@unlink("{$storagePath}/config.php");

// Setup SQLite in /tmp by copying pre-seeded database if present
$dbFile = '/tmp/database.sqlite';
$seededDb = $basePath . '/database/database.sqlite';

if (file_exists($seededDb)) {
    if (!file_exists($dbFile) || filemtime($seededDb) > filemtime($dbFile)) {
        @copy($seededDb, $dbFile);
    }
} else if (!file_exists($dbFile)) {
    @touch($dbFile);
}
putenv("DB_DATABASE={$dbFile}");
$_ENV['DB_DATABASE'] = $dbFile;
$_SERVER['DB_DATABASE'] = $dbFile;

// Require Autoload & App
require_once $basePath . '/vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

// Allow /tmp as absolute cache path prefix
$app->addAbsoluteCachePathPrefix('/tmp');

// Register core providers explicitly for Vercel Serverless
$app->register(\Illuminate\Events\EventServiceProvider::class);
$app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->register(\Illuminate\View\ViewServiceProvider::class);

// Handle Request
$request = Illuminate\Http\Request::capture();
$app->handleRequest($request);





