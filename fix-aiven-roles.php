#!/usr/bin/env php
<?php

/**
 * Script untuk update role di database Aiven
 * Jalankan: php fix-aiven-roles.php
 */

echo "=== Fix Aiven Database Roles ===\n\n";

// Load environment dari .env.vercel (ganti dengan kredensial asli Anda)
echo "Masukkan kredensial Aiven database:\n";
echo "Host (contoh: mysql-xxx.aivencloud.com): ";
$host = trim(fgets(STDIN));

echo "Port (contoh: 12345): ";
$port = trim(fgets(STDIN));

echo "Database name (contoh: contractor): ";
$database = trim(fgets(STDIN));

echo "Username: ";
$username = trim(fgets(STDIN));

echo "Password: ";
$password = trim(fgets(STDIN));

echo "\n🔌 Connecting to database...\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => true, // Aiven requires SSL
    ]);
    
    echo "✅ Connected successfully!\n\n";
    
    // 1. Cek role yang ada
    echo "📋 Checking existing roles...\n";
    $stmt = $pdo->query("SELECT id, name FROM roles ORDER BY id");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Roles found:\n";
    foreach ($roles as $role) {
        echo "  - [{$role['id']}] {$role['name']}\n";
    }
    echo "\n";
    
    // 2. Cek apakah ada role 'superadministrator'
    $stmt = $pdo->prepare("SELECT id FROM roles WHERE name = ?");
    $stmt->execute(['superadministrator']);
    $oldRole = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 3. Cek apakah ada role 'superadmin'
    $stmt = $pdo->prepare("SELECT id FROM roles WHERE name = ?");
    $stmt->execute(['superadmin']);
    $newRole = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($oldRole && !$newRole) {
        echo "🔧 Found 'superadministrator' role, will rename to 'superadmin'...\n";
        
        // Update role name
        $stmt = $pdo->prepare("UPDATE roles SET name = ? WHERE name = ?");
        $stmt->execute(['superadmin', 'superadministrator']);
        
        echo "✅ Role renamed successfully!\n\n";
    } elseif ($newRole) {
        echo "✅ Role 'superadmin' already exists!\n\n";
    } else {
        echo "⚠️  Neither 'superadmin' nor 'superadministrator' found!\n";
        echo "💡 Running seeder might be needed.\n\n";
    }
    
    // 4. Tampilkan users dengan role superadmin/superadministrator
    echo "👥 Checking users with admin roles...\n";
    $stmt = $pdo->query("
        SELECT u.id, u.name, u.email, r.name as role_name
        FROM users u
        JOIN model_has_roles mhr ON u.id = mhr.model_id
        JOIN roles r ON mhr.role_id = r.id
        WHERE r.name IN ('superadmin', 'superadministrator', 'administrator')
        ORDER BY u.id
    ");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "Users found:\n";
        foreach ($users as $user) {
            echo "  - {$user['name']} ({$user['email']}) => Role: {$user['role_name']}\n";
        }
    } else {
        echo "⚠️  No admin users found!\n";
        echo "💡 You may need to run SuperAdminSeeder.\n";
    }
    
    echo "\n✅ Done!\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
