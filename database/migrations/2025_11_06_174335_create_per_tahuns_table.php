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
            $table->date('periode_per_tahun')->nullable();
            $table->string('biodata_path')->nullable();
            $table->string('sertifikat_pendidik_path')->nullable();
            $table->string('sk_dirjen_kelulusan_path')->nullable();
            $table->string('nrg_path')->nullable();
            $table->string('nuptk_path')->nullable();
            $table->string('npwp_path')->nullable();
            $table->string('ktp_path')->nullable();
            $table->string('ijazah_sd_path')->nullable();
            $table->string('ijazah_smp_path')->nullable();
            $table->string('ijazah_sma_pga_path')->nullable();
            $table->string('sk_pns_gty_path')->nullable();
            $table->string('ijazah_s1_path')->nullable();
            $table->string('transkrip_nilai_s1_path')->nullable();
            $table->enum('status', ['menunggu', 'belum lengkap', 'diterima', 'ditolak'])->default('menunggu');
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
