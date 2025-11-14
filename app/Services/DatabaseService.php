<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseService
{
    /**
     * Get connection name for local database
     */
    public static function local(): string
    {
        return 'mysql';
    }

    /**
     * Get connection name for Aiven database
     */
    public static function aiven(): string
    {
        return 'aiven';
    }

    /**
     * Get the default connection
     */
    public static function default(): string
    {
        return Config::get('database.default');
    }

    /**
     * Check if a connection is available
     */
    public static function connectionExists(string $connection): bool
    {
        try {
            DB::connection($connection)->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get connection info
     */
    public static function getConnectionInfo(string $connection): array
    {
        $config = Config::get("database.connections.{$connection}");
        
        if (!$config) {
            return [];
        }

        return [
            'driver' => $config['driver'],
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $config['database'],
            'username' => $config['username'],
            'is_aiven' => $connection === 'aiven',
            'is_local' => $connection === 'mysql',
        ];
    }

    /**
     * Switch default connection temporarily
     */
    public static function useConnection(string $connection, callable $callback)
    {
        $originalConnection = Config::get('database.default');
        
        try {
            Config::set('database.default', $connection);
            return $callback();
        } finally {
            Config::set('database.default', $originalConnection);
        }
    }

    /**
     * Execute query on specific connection
     */
    public static function query(string $connection, string $sql, array $bindings = [])
    {
        return DB::connection($connection)->select($sql, $bindings);
    }

    /**
     * Execute raw statement on specific connection
     */
    public static function statement(string $connection, string $sql, array $bindings = []): bool
    {
        return DB::connection($connection)->statement($sql, $bindings);
    }

    /**
     * Get table list from specific connection
     */
    public static function getTables(string $connection): array
    {
        try {
            $result = DB::connection($connection)
                ->select('SHOW TABLES');
            
            $tables = [];
            foreach ($result as $table) {
                $tableArray = (array) $table;
                $tables[] = array_values($tableArray)[0];
            }
            
            return $tables;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Sync data from one connection to another
     */
    public static function syncTable(string $fromConnection, string $toConnection, string $table): bool
    {
        try {
            // Get data from source
            $data = DB::connection($fromConnection)
                ->table($table)
                ->get()
                ->toArray();

            if (empty($data)) {
                return true;
            }

            // Clear destination table
            DB::connection($toConnection)->table($table)->truncate();

            // Insert data to destination
            DB::connection($toConnection)->table($table)->insert($data);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get database size info
     */
    public static function getDatabaseSize(string $connection): array
    {
        try {
            $config = self::getConnectionInfo($connection);
            $database = $config['database'];
            
            $result = DB::connection($connection)
                ->select("
                    SELECT 
                        table_name,
                        ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb
                    FROM information_schema.tables 
                    WHERE table_schema = ?
                    ORDER BY (data_length + index_length) DESC
                ", [$database]);

            return array_map(function ($item) {
                return [
                    'table' => $item->table_name,
                    'size_mb' => $item->size_mb
                ];
            }, $result);
        } catch (\Exception $e) {
            return [];
        }
    }
}
