<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\PackageManifest;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'debug.auth' => \App\Http\Middleware\DebugAuthMiddleware::class,
        ]);
        // Trust all proxies for Vercel deployment
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle CSRF Token Mismatch (419 Error)
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            return redirect()->route('login')
                ->with('error', '⚠️ Sesi login Anda telah berakhir. Silakan login kembali.')
                ->with('info', 'Untuk keamanan, halaman login akan otomatis direfresh setelah 10 menit.');
        });
    })->create();

// Clean bootstrap - providers are now explicit in bootstrap/providers.php

return $app;
