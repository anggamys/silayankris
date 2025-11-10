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
        Schema::create('per_semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('sk_pbm_path');
            $table->string('sk_terakhir_path')->nullable();
            $table->string('sk_berkala_path')->nullable();
            $table->string('sp_bersedia_mengembalikan_path');
            $table->string('sp_perangkat_pembelajaran_path');
            $table->string('keaktifan_simpatika_path');
            $table->string('berkas_s28a_path');
            $table->string('berkas_skmt_path');
            $table->string('permohonan_skbk_path');
            $table->string('berkas_skbk_path');
            $table->string('sertifikat_pengembangan_diri_path');
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
        Schema::dropIfExists('per_semesters');
    }
};
