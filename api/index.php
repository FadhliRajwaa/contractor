<?php

// Vercel serverless entry point for Laravel
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Autoload dependencies
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    http_response_code(500);
    exit('Vendor autoload not found. Please run composer install.');
}

// Setup Vercel serverless environment BEFORE Laravel bootstrap
require_once __DIR__.'/../bootstrap/vercel.php';

// Bootstrap Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    // Handle the request
    $kernel = $app->make(Kernel::class);
    
    $response = $kernel->handle(
        $request = Request::capture()
    );
    
    $response->send();
    
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    // Enhanced error handling for debugging
    http_response_code(500);
    
    // Always show detailed error for now to debug
    echo "<!DOCTYPE html><html><head><title>Laravel Error</title></head><body>";
    echo "<h1>Application Error</h1>";
    echo "<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "<h3>Environment Info:</h3>";
    echo "<pre>";
    echo "APP_ENV: " . ($_ENV['APP_ENV'] ?? 'not set') . "\n";
    echo "APP_DEBUG: " . ($_ENV['APP_DEBUG'] ?? 'not set') . "\n";
    echo "VERCEL: " . ($_ENV['VERCEL'] ?? 'not set') . "\n";
    echo "DB_CONNECTION: " . ($_ENV['DB_CONNECTION'] ?? 'not set') . "\n";
    echo "</pre>";
    echo "</body></html>";
}
