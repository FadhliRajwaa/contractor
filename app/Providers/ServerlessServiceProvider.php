<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\PackageManifest;

class ServerlessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Override PackageManifest for serverless environments
        if ($this->isServerlessEnvironment()) {
            $this->app->singleton(PackageManifest::class, function ($app) {
                $manifest = new PackageManifest(
                    $app->make('files'),
                    $app->basePath(),
                    '/tmp/bootstrap/cache/packages.php'
                );
                
                return $manifest;
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Create necessary directories for serverless
        if ($this->isServerlessEnvironment()) {
            $this->createServerlessDirectories();
        }
    }

    /**
     * Check if running in serverless environment
     */
    private function isServerlessEnvironment(): bool
    {
        return isset($_ENV['VERCEL']) || 
               isset($_ENV['AWS_LAMBDA_FUNCTION_NAME']) ||
               !is_writable($this->app->bootstrapPath('cache'));
    }

    /**
     * Create necessary directories for serverless
     */
    private function createServerlessDirectories(): void
    {
        $directories = [
            '/tmp/bootstrap',
            '/tmp/bootstrap/cache',
            '/tmp/storage',
            '/tmp/storage/framework',
            '/tmp/storage/framework/cache',
            '/tmp/storage/framework/sessions',
            '/tmp/storage/framework/views',
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }
}
