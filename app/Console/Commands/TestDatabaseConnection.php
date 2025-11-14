<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TestDatabaseConnection extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:test-connection {connection? : Database connection to test (mysql/aiven)}';

    /**
     * The console command description.
     */
    protected $description = 'Test the current database connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connectionName = $this->argument('connection') ?: Config::get('database.default');
        
        $this->info("Testing {$connectionName} database connection...");
        $this->newLine();

        try {
            // Get database configuration
            $config = Config::get("database.connections.{$connectionName}");
            
            if (!$config) {
                $this->error("Connection '{$connectionName}' not found!");
                $this->line('Available connections: mysql, aiven');
                return 1;
            }
            
            $this->info('Current Configuration:');
            $this->line("Connection: {$connectionName}");
            $this->line("Host: {$config['host']}");
            $this->line("Port: {$config['port']}");
            $this->line("Database: {$config['database']}");
            $this->line("Username: {$config['username']}");
            
            $isAiven = $connectionName === 'aiven';
            $this->line("Environment: " . ($isAiven ? 'AIVEN CLOUD' : 'LOCAL'));
            
            if ($isAiven) {
                $this->line("SSL Mode: REQUIRED");
            }
            
            $this->newLine();

            // Test the connection
            $startTime = microtime(true);
            DB::connection($connectionName)->getPdo();
            $endTime = microtime(true);
            
            $this->info('✅ Connection successful!');
            $this->line('Connection time: ' . round(($endTime - $startTime) * 1000, 2) . 'ms');
            
            // Test a simple query
            $this->info('Testing simple query...');
            $result = DB::connection($connectionName)->select('SELECT 1 as test');
            
            if ($result[0]->test == 1) {
                $this->info('✅ Query execution successful!');
            }
            
            // Check server version
            $version = DB::connection($connectionName)->select('SELECT VERSION() as version')[0]->version;
            $this->line("MySQL Version: {$version}");
            
            $this->newLine();
            $this->info('Database connection is working properly! 🚀');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Connection failed!');
            $this->error('Error: ' . $e->getMessage());
            
            $this->newLine();
            $this->warn('Troubleshooting steps:');
            
            if ($connectionName === 'aiven') {
                $this->line('1. Check Aiven database credentials in .env');
                $this->line('2. Ensure SSL is properly configured');
                $this->line('3. Check firewall/network connectivity');
                $this->line('4. Verify Aiven service is running');
                $this->line('5. Check if IP is whitelisted in Aiven Console');
            } else {
                $this->line('1. Check local MySQL service is running');
                $this->line('2. Verify database credentials');
                $this->line('3. Ensure database exists');
                $this->line('4. Check XAMPP/WAMP is running');
            }
            
            return 1;
        }
    }
}
