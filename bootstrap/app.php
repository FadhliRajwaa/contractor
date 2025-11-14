<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\PackageManifest;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        // Trust all proxies for Vercel deployment
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Override PackageManifest for serverless environments
$app->singleton(PackageManifest::class, function ($app) {
    // Use /tmp for cache if in Vercel or bootstrap/cache not writable
    $isServerless = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || 
                    ($_ENV['APP_ENV'] ?? '') === 'production' || 
                    !is_writable($app->bootstrapPath('cache'));
                    
    $cachePath = $isServerless 
        ? '/tmp/bootstrap/cache/packages.php'
        : $app->bootstrapPath('cache/packages.php');
        
    return new PackageManifest(
        $app->make('files'),
        $app->basePath(),
        $cachePath
    );
});

// Override other bootstrap paths for serverless
$isServerless = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || 
                ($_ENV['APP_ENV'] ?? '') === 'production' || 
                !is_writable($app->bootstrapPath('cache'));
                
if ($isServerless) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
