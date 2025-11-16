<?php
// Vercel Serverless Configuration for Laravel - Working Approach

// Custom error handler to catch ALL errors
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    header('Content-Type: application/json');
    die(json_encode([
        'error' => 'PHP Error',
        'type' => $errno,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ], JSON_PRETTY_PRINT));
});

// Custom exception handler
set_exception_handler(function($e) {
    http_response_code(500);
    header('Content-Type: application/json');
    die(json_encode([
        'error' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => array_slice(explode("\n", $e->getTraceAsString()), 0, 15)
    ], JSON_PRETTY_PRINT));
});

// Enable error display
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Create required tmp directories FIRST
$dirs = [
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/testing',
    '/tmp/storage/logs',
    '/tmp/views'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Create minimal .env file in /tmp (writable area)
$envFile = '/tmp/.env';
if (!file_exists($envFile)) {
    file_put_contents($envFile, "# Managed by Vercel\n");
}

// Copy .env to writable location if needed
$sourceEnv = __DIR__ . '/../.env';
if (file_exists($sourceEnv) && !file_exists($envFile)) {
    @copy($sourceEnv, $envFile);
}

// Override specific paths for serverless
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['APP_STORAGE'] = '/tmp/storage';

// Custom Laravel bootstrap for Vercel serverless
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel with custom environment file location
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Override useEnvironmentPath to /tmp BEFORE loading environment
$app->useEnvironmentPath('/tmp');

// Handle the request
$app->handleRequest(Request::capture());
