<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:migrate {connection : Database connection (mysql/aiven)} {--fresh : Run fresh migrations} {--seed : Run database seeder}';

    /**
     * The console command description.
     */
    protected $description = 'Migrate database to specific connection (mysql/aiven)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = $this->argument('connection');
        
        // Validate connection
        if (!in_array($connection, ['mysql', 'aiven'])) {
            $this->error('Invalid connection! Use "mysql" or "aiven"');
            return 1;
        }

        $this->info("🚀 Starting migration to {$connection} database...");
        $this->newLine();

        // Test connection first
        $this->info("Testing {$connection} connection...");
        $exitCode = Artisan::call('db:test-connection', ['connection' => $connection]);
        
        if ($exitCode !== 0) {
            $this->error("❌ Cannot connect to {$connection} database!");
            $this->info(Artisan::output());
            return 1;
        }

        $this->info("✅ {$connection} connection successful!");
        $this->newLine();

        try {
            $migrateOptions = [
                '--database' => $connection,
                '--force' => true
            ];

            if ($this->option('fresh')) {
                $this->warn('Running FRESH migrations (this will drop all tables)...');
                if (!$this->confirm("Are you sure? This will delete all existing data in {$connection}!")) {
                    $this->info('Migration cancelled.');
                    return 1;
                }
                
                $this->info("Running: php artisan migrate:fresh --database={$connection}");
                Artisan::call('migrate:fresh', $migrateOptions);
            } else {
                $this->info("Running: php artisan migrate --database={$connection}");
                Artisan::call('migrate', $migrateOptions);
            }
            
            $this->info(Artisan::output());
            
            if ($this->option('seed')) {
                $this->info("Running database seeder on {$connection}...");
                Artisan::call('db:seed', [
                    '--database' => $connection,
                    '--force' => true
                ]);
                $this->info(Artisan::output());
            }
            
            $this->newLine();
            $this->info("🎉 Migration to {$connection} completed successfully!");
            $this->newLine();
            
            if ($connection === 'aiven') {
                $this->info('Next steps for Aiven:');
                $this->line('1. Verify data in Aiven Console');
                $this->line('2. Test application functionality');
                $this->line('3. Monitor performance and connection limits');
            } else {
                $this->info('Next steps for Local:');
                $this->line('1. Test application with local database');
                $this->line('2. Verify all features work correctly');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Migration failed!');
            $this->error('Error: ' . $e->getMessage());
            
            $this->newLine();
            $this->warn('Troubleshooting:');
            
            if ($connection === 'aiven') {
                $this->line('1. Check migration files for Aiven MySQL compatibility');
                $this->line('2. Verify Aiven MySQL version support');
                $this->line('3. Check for any custom SQL that might not work on Aiven');
                $this->line('4. Monitor connection timeout in Aiven Console');
            } else {
                $this->line('1. Check local MySQL service is running');
                $this->line('2. Verify migration files syntax');
                $this->line('3. Check database permissions');
            }
            
            return 1;
        }
    }
}
