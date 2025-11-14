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
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || !is_writable($app->bootstrapPath('cache'))) {
    $app->singleton(PackageManifest::class, function ($app) {
        return new PackageManifest(
            $app->make('files'),
            $app->basePath(),
            '/tmp/bootstrap/cache/packages.php'
        );
    });
}

return $app;
