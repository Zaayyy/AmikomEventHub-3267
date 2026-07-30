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
$_ENV['APP_STORAGE_PATH'] = $storagePath;
$_SERVER['APP_STORAGE_PATH'] = $storagePath;

// Setup SQLite in /tmp by copying pre-seeded database if present
$dbFile = '/tmp/database.sqlite';
if (!file_exists($dbFile)) {
    $seededDb = $basePath . '/database/database.sqlite';
    if (file_exists($seededDb)) {
        @copy($seededDb, $dbFile);
    } else {
        @touch($dbFile);
    }
}
putenv("DB_DATABASE={$dbFile}");
$_ENV['DB_DATABASE'] = $dbFile;
$_SERVER['DB_DATABASE'] = $dbFile;

// Require Autoload & App
require_once $basePath . '/vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

// Handle Request
$request = Illuminate\Http\Request::capture();
$response = $app->handleRequest($request);
$response->send();





