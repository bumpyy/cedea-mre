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
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('admin_id_area')->nullable();
            $table->timestamp('admin_area_assigned_at')->after('admin_id_area')->nullable();
            $table->timestamp('admin_area_processed_at')->after('admin_id_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('admin_id_area');
            $table->dropColumn('admin_area_assigned_at');
            $table->dropColumn('admin_area_processed_at');
        });
    }
};
