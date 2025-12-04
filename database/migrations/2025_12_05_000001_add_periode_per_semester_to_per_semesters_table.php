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
        if (!Schema::hasTable('per_semesters')) {
            return;
        }

        if (!Schema::hasColumn('per_semesters', 'periode_per_semester')) {
            Schema::table('per_semesters', function (Blueprint $table) {
                $table->string('periode_per_semester')->nullable()->after('guru_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('per_semesters')) {
            return;
        }

        if (Schema::hasColumn('per_semesters', 'periode_per_semester')) {
            Schema::table('per_semesters', function (Blueprint $table) {
                $table->dropColumn('periode_per_semester');
            });
        }
    }
};
