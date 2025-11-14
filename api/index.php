<?php

// Vercel serverless entry point for Laravel
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if the application is already bootstrapped
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    exit('Please run "composer install" to install dependencies.');
}

// Bootstrap Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle the request
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
