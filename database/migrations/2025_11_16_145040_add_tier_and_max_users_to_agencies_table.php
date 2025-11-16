<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            // Check if columns don't exist to prevent error on different environments
            if (!Schema::hasColumn('agencies', 'tier')) {
                $table->unsignedTinyInteger('tier')->default(3)->after('is_active')
                    ->comment('Tier level: 3=Basic (10 users), 4=Standard (25 users), 5=Premium (50 users)');
            }
            
            if (!Schema::hasColumn('agencies', 'max_users')) {
                $table->unsignedInteger('max_users')->default(10)->after('tier')
                    ->comment('Maximum users allowed for this agency');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            if (Schema::hasColumn('agencies', 'max_users')) {
                $table->dropColumn('max_users');
            }
            
            if (Schema::hasColumn('agencies', 'tier')) {
                $table->dropColumn('tier');
            }
        });
    }
};
