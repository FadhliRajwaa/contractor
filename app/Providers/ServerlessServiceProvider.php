<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServerlessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Set storage path for serverless
        if ($this->isServerlessEnvironment()) {
            // Override storage path using environment variable
            putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
            $_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
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
               $this->app->environment('production');
    }

    /**
     * Create necessary directories for serverless
     */
    private function createServerlessDirectories(): void
    {
        $directories = [
            '/tmp/storage',
            '/tmp/storage/app',
            '/tmp/storage/framework',
            '/tmp/storage/framework/cache',
            '/tmp/storage/framework/sessions',
            '/tmp/storage/framework/views',
            '/tmp/storage/logs',
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }
}
