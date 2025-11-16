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
        Schema::table('users', function (Blueprint $table) {
            // Check if column doesn't exist to prevent error on different environments
            if (!Schema::hasColumn('users', 'agency_id')) {
                $table->foreignId('agency_id')->nullable()->after('id')
                    ->constrained('agencies')
                    ->onUpdate('cascade')
                    ->onDelete('set null')
                    ->comment('Agency/Kontraktor yang user ini tergabung');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'agency_id')) {
                $table->dropForeign(['agency_id']);
                $table->dropColumn('agency_id');
            }
        });
    }
};
