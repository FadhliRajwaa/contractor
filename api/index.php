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
    // Error handling for debugging
    http_response_code(500);
    
    if (env('APP_DEBUG', false)) {
        echo "Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . "\n";
        echo "Line: " . $e->getLine() . "\n";
    } else {
        echo "Application Error";
    }
}
