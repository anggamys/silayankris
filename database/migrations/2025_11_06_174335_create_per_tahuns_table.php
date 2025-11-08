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
            $table->string('biodata_path');
            $table->string('sertifikat_pendidik_path');
            $table->string('sk_dirjen_path')->nullable();
            $table->string('sk_kelulusan_path')->nullable();
            $table->string('nrg_path');
            $table->string('nuptk_path');
            $table->string('npwp_path');
            $table->string('ktp_path');
            $table->string('ijazah_sd_path');
            $table->string('ijazah_smp_path');
            $table->string('ijazah_sma_path');
            $table->string('sk_pns_path');
            $table->string('sk_gty_path');
            $table->string('ijazah_s1_path');
            $table->string('transkrip_nilai_s1_path');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak']);
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
