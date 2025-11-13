<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('gerejas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_berdiri')->nullable();
            $table->date('tanggal_bergabung_sinode')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kel_desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kab_kota')->nullable();
            $table->string('jarak_gereja_lain')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('nama_pendeta')->nullable();

            $table->enum('status_gereja', ['permanen', 'semi-permanen', 'tidak-permanen'])
                  ->default('permanen')
                  ->nullable();

            $table->json('jumlah_umat')->nullable();
            $table->json('jumlah_majelis')->nullable();
            $table->json('jumlah_guru_sekolah_minggu')->nullable();
            $table->json('jumlah_murid_sekolah_minggu')->nullable();
            $table->json('jumlah_pemuda')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerejas');
    }
};
