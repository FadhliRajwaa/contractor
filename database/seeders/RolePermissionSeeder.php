<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Customer management (untuk kontraktor)
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            
            // Project management (untuk kontraktor)
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            
            // Agency management (untuk kontraktor)
            'view agencies',
            'create agencies',
            'edit agencies',
            'delete agencies',
            
            // Dashboard levels
            'view dashboard',
            'view admin dashboard',
            'view contractor dashboard',
            'view customer dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. SUPERADMIN - Full system control
        $superadmin = Role::create(['name' => 'superadmin']);
        $superadmin->givePermissionTo(Permission::all());

        // 2. ADMINISTRATOR - System administrator
        $administrator = Role::create(['name' => 'administrator']);
        $administrator->givePermissionTo([
            'view users',
            'create users', 
            'edit users',
            'delete users',
            'view roles',
            'view dashboard',
            'view admin dashboard',
        ]);

        // 3. ADMIN (Kontraktor) - Administrator dari kontraktor, bisa buat customer, user, dan agency
        $admin_kontraktor = Role::create(['name' => 'admin_kontraktor']);
        $admin_kontraktor->givePermissionTo([
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            'create users', // bisa buat user kontraktor & customer
            'edit users',   // bisa edit user kontraktor & customer
            'view users',   // bisa lihat user kontraktor & customer
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            'view agencies',
            'create agencies',
            'edit agencies',
            'delete agencies',
            'view dashboard',
            'view contractor dashboard',
        ]);

        // 4. USER (Kontraktor) - User biasa kontraktor
        $user_kontraktor = Role::create(['name' => 'user_kontraktor']);
        $user_kontraktor->givePermissionTo([
            'view customers',
            'view projects',
            'edit projects', // terbatas
            'view dashboard',
            'view contractor dashboard',
        ]);

        // 5. CUSTOMER - Viewer untuk kontraktor
        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo([
            'view projects', // hanya yang assigned ke mereka
            'view dashboard',
            'view customer dashboard',
        ]);
    }
}
