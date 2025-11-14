<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * PENTING: Ganti password ini setelah deployment pertama!
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@contractor.test',
            'password' => Hash::make('password123'), // GANTI PASSWORD INI!
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $superAdmin->assignRole('superadmin');
        
        $this->command->info('✅ Super Administrator berhasil dibuat!');
        $this->command->warn('📧 Email: superadmin@contractor.test');
        $this->command->warn('🔑 Password: password123');
        $this->command->error('⚠️  PENTING: Ganti password ini setelah login pertama!');
    }
}
