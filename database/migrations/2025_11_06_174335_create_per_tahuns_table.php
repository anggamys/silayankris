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
        Schema::create('per_tahuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('biodata_path')->nullable();
            $table->string('sertifikat_pendidik_path')->nullable();
            $table->string('sk_dirjen_path')->nullable();
            $table->string('sk_kelulusan_path')->nullable();
            $table->string('nrg_path')->nullable();
            $table->string('nuptk_path')->nullable();
            $table->string('npwp_path')->nullable();
            $table->string('ktp_path')->nullable();
            $table->string('ijazah_sd_path')->nullable();
            $table->string('ijazah_smp_path')->nullable();
            $table->string('ijazah_sma_path')->nullable();
            $table->string('sk_pns_path')->nullable();
            $table->string('sk_gty_path')->nullable();
            $table->string('ijazah_s1_path')->nullable();
            $table->string('transkrip_nilai_s1_path')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('per_tahuns');
    }
};
