<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseService;

class DatabaseInfo extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:info {connection? : Database connection to check (mysql/aiven)}';

    /**
     * The console command description.
     */
    protected $description = 'Show database information and statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = $this->argument('connection');
        
        if ($connection) {
            $this->showConnectionInfo($connection);
        } else {
            $this->showAllConnections();
        }

        return 0;
    }

    /**
     * Show information for all connections
     */
    private function showAllConnections()
    {
        $this->info('=== DATABASE CONNECTIONS INFO ===');
        $this->newLine();

        $connections = ['mysql', 'aiven'];
        
        foreach ($connections as $connection) {
            $this->showConnectionInfo($connection);
            $this->newLine();
        }
    }

    /**
     * Show information for specific connection
     */
    private function showConnectionInfo(string $connection)
    {
        $this->info("📊 {$connection} Database Info");
        $this->line(str_repeat('-', 50));

        // Connection details
        $config = DatabaseService::getConnectionInfo($connection);
        
        if (empty($config)) {
            $this->error("Connection '{$connection}' not found!");
            return;
        }

        $this->line("Host: {$config['host']}:{$config['port']}");
        $this->line("Database: {$config['database']}");
        $this->line("Username: {$config['username']}");
        $this->line("Type: " . ($config['is_aiven'] ? 'Aiven Cloud' : 'Local MySQL'));

        // Test connection
        if (DatabaseService::connectionExists($connection)) {
            $this->line("Status: ✅ Connected");
            
            // Get tables
            $tables = DatabaseService::getTables($connection);
            $this->line("Tables: " . count($tables));
            
            if (!empty($tables)) {
                $this->line("Table List: " . implode(', ', $tables));
                
                // Get database size
                $sizes = DatabaseService::getDatabaseSize($connection);
                if (!empty($sizes)) {
                    $this->newLine();
                    $this->line("📈 Table Sizes:");
                    
                    $headers = ['Table', 'Size (MB)'];
                    $rows = array_map(function ($item) {
                        return [$item['table'], $item['size_mb']];
                    }, array_slice($sizes, 0, 10)); // Show top 10 tables
                    
                    $this->table($headers, $rows);
                    
                    $totalSize = array_sum(array_column($sizes, 'size_mb'));
                    $this->line("Total Database Size: {$totalSize} MB");
                }
            }
        } else {
            $this->line("Status: ❌ Connection Failed");
            
            if ($config['is_aiven']) {
                $this->warn("Aiven connection issues:");
                $this->line("1. Check network connectivity");
                $this->line("2. Verify credentials in .env");
                $this->line("3. Check Aiven service status");
            } else {
                $this->warn("Local MySQL issues:");
                $this->line("1. Check if MySQL/XAMPP is running");
                $this->line("2. Verify database exists");
                $this->line("3. Check credentials");
            }
        }
    }
}
