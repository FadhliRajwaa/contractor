<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class FixProductionRoles extends Command
{
    protected $signature = 'fix:production-roles';
    protected $description = 'Fix role names in production database (superadministrator -> superadmin)';

    public function handle()
    {
        $this->info('🔧 Fixing production roles...');
        
        try {
            // Check if superadministrator role exists
            $oldRole = Role::where('name', 'superadministrator')->first();
            $newRole = Role::where('name', 'superadmin')->first();
            
            if ($oldRole && !$newRole) {
                $this->info('Found role "superadministrator", renaming to "superadmin"...');
                
                // Simply rename the role
                DB::table('roles')
                    ->where('name', 'superadministrator')
                    ->update(['name' => 'superadmin']);
                
                // Clear cache
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
                
                $this->info('✅ Role renamed successfully!');
            } elseif ($newRole) {
                $this->info('✅ Role "superadmin" already exists!');
            } else {
                $this->warn('⚠️  Neither "superadmin" nor "superadministrator" found!');
                $this->warn('💡 You may need to run: php artisan db:seed --class=RolePermissionSeeder');
            }
            
            // Show all admin users
            $this->info('');
            $this->info('👥 Admin users:');
            
            $users = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['superadmin', 'superadministrator', 'administrator'])
                ->select('users.name', 'users.email', 'roles.name as role_name')
                ->get();
            
            if ($users->count() > 0) {
                foreach ($users as $user) {
                    $this->line("  - {$user->name} ({$user->email}) => {$user->role_name}");
                }
            } else {
                $this->warn('  No admin users found!');
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
