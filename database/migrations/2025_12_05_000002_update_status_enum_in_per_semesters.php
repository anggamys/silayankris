<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('per_semesters')) {
            return;
        }

        // Update the enum to include 'belum lengkap' if not present.
        // Use raw statement because changing enum via Schema may require doctrine/dbal.
        DB::statement("ALTER TABLE `per_semesters` MODIFY `status` ENUM('menunggu','diterima','ditolak','belum lengkap') NOT NULL DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('per_semesters')) {
            return;
        }

        DB::statement("ALTER TABLE `per_semesters` MODIFY `status` ENUM('menunggu','diterima','ditolak') NOT NULL DEFAULT 'menunggu'");
    }
};
