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
        Schema::create('gerejas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_berdiri');
            $table->date('tanggal_bergabung_sinode');
            $table->string('alamat');
            $table->string('kel_desa');
            $table->string('kecamatan');
            $table->string('kab_kota');
            $table->string('jarak_gereja_lain');
            $table->string('nomor_telepon');

            // $table->string('email');
            // $table->string('nama_pendeta');

            $table->enum('status_gereja', ['permanen', 'semi-permanen', 'tidak-permanen'])->default('permanen');
            $table->json('jumlah_umat');
            $table->json('jumlah_majelis');
            $table->json('jumlah_guru_sekolah_minggu');
            $table->json('jumlah_pemuda');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerejas');
    }
};
