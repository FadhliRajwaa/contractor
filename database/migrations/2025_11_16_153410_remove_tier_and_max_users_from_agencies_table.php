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
            // Drop tier and max_users columns as they are not needed
            // Only admin_kontraktor role has limit (max 5), enforced by application logic
            if (Schema::hasColumn('agencies', 'max_users')) {
                $table->dropColumn('max_users');
            }
            
            if (Schema::hasColumn('agencies', 'tier')) {
                $table->dropColumn('tier');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            // Re-add columns if rollback is needed
            if (!Schema::hasColumn('agencies', 'tier')) {
                $table->unsignedTinyInteger('tier')->default(3)->after('is_active');
            }
            
            if (!Schema::hasColumn('agencies', 'max_users')) {
                $table->unsignedInteger('max_users')->default(10)->after('tier');
            }
        });
    }
};
