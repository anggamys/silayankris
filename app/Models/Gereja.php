<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gereja extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, sesuai konvensi Laravel)
     */
    protected $table = 'gerejas';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'tanggal_berdiri',
        'tanggal_bergabung_sinode',
        'alamat',
        'kel_desa',
        'kecamatan',
        'kab_kota',
        'jarak_gereja_lain',
        'nomor_telepon',
        'status_gereja',
        'jumlah_umat',
        'jumlah_majelis',
        'jumlah_guru_sekolah_minggu',
        'jumlah_pemuda',
    ];

    /**
     * Tipe data casting agar kolom JSON otomatis dikonversi ke array.
     */
    protected $casts = [
        'jumlah_umat' => 'array',
        'jumlah_majelis' => 'array',
        'jumlah_guru_sekolah_minggu' => 'array',
        'jumlah_pemuda' => 'array',
        'tanggal_berdiri' => 'date',
        'tanggal_bergabung_sinode' => 'date',
    ];
}
