<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VercelDeploy extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'deploy:vercel {--production : Deploy to production}';

    /**
     * The console command description.
     */
    protected $description = 'Prepare application for Vercel deployment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Preparing Laravel app for Vercel deployment...');
        $this->newLine();

        // 1. Check if vercel.json exists
        if (!file_exists(base_path('vercel.json'))) {
            $this->error('❌ vercel.json not found! Please ensure Vercel configuration exists.');
            return 1;
        }

        $this->info('✅ vercel.json found');

        // 2. Check if api/index.php exists
        if (!file_exists(base_path('api/index.php'))) {
            $this->error('❌ api/index.php not found! Please ensure Vercel entry point exists.');
            return 1;
        }

        $this->info('✅ api/index.php found');

        // 3. Optimize for production
        $this->info('📦 Optimizing application...');
        
        try {
            $this->call('config:cache');
            $this->call('route:cache');
            $this->call('view:cache');
            
            $this->info('✅ Laravel caches created');
        } catch (\Exception $e) {
            $this->warn('⚠️  Some caching failed: ' . $e->getMessage());
        }

        // 4. Check environment configuration
        $this->info('🔧 Vercel deployment checklist:');
        $this->newLine();

        $checklist = [
            'vercel.json configured' => file_exists(base_path('vercel.json')),
            'api/index.php entry point' => file_exists(base_path('api/index.php')),
            'Composer scripts ready' => $this->checkComposerScripts(),
            'Package.json scripts ready' => $this->checkPackageScripts(),
        ];

        foreach ($checklist as $item => $status) {
            if ($status) {
                $this->line("✅ {$item}");
            } else {
                $this->line("❌ {$item}");
            }
        }

        $this->newLine();
        $this->info('📋 Environment Variables to set in Vercel:');
        $this->line('1. APP_KEY - Generate with: php artisan key:generate --show');
        $this->line('2. APP_URL - Your Vercel app URL');
        $this->line('3. AIVEN_DB_* - Your Aiven database credentials');
        $this->line('4. APP_ENV=production');
        $this->line('5. APP_DEBUG=false');

        $this->newLine();
        $this->info('🚀 Next steps:');
        $this->line('1. Install Vercel CLI: npm i -g vercel');
        $this->line('2. Run: vercel --prod');
        $this->line('3. Set environment variables in Vercel dashboard');
        $this->line('4. Configure custom domain if needed');

        $this->newLine();
        $this->info('✨ App is ready for Vercel deployment!');

        return 0;
    }

    /**
     * Check if composer scripts are configured
     */
    private function checkComposerScripts(): bool
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        return isset($composer['scripts']['vercel-build']);
    }

    /**
     * Check if package.json scripts are configured
     */
    private function checkPackageScripts(): bool
    {
        if (!file_exists(base_path('package.json'))) {
            return false;
        }
        
        $package = json_decode(file_get_contents(base_path('package.json')), true);
        return isset($package['scripts']['vercel-build']);
    }
}
