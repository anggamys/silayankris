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
        Schema::create('per_bulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->date('periode_per_bulan')->nullable();
            $table->string('daftar_gaji_path')->nullable();
            $table->string('daftar_hadir_path')->nullable();
            $table->string('rekening_bank_path')->nullable();
            $table->string('ceklist_berkas')->nullable();
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
        Schema::dropIfExists('per_bulans');
    }
};
