<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;

class PerTahun extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, sudah sesuai konvensi Laravel)
     */
    protected $table = 'per_tahuns';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'guru_id',
        'periode_per_tahun',
        'biodata_path',
        'sertifikat_pendidik_path',
        'sk_dirjen_kelulusan_path',
        'nrg_path',
        'nuptk_path',
        'npwp_path',
        'ktp_path',
        'ijazah_sd_path',
        'ijazah_smp_path',
        'ijazah_sma_pga_path',
        'sk_pns_gty_path',
        'ijazah_s1_path',
        'transkrip_nilai_s1_path',
        'status',
        'catatan',
    ];

    /**
     * Relasi: setiap data per_tahun dimiliki oleh satu guru.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Casting untuk kolom tertentu.
     */
    protected $casts = [
        'guru_id' => 'integer',
        'status' => 'string',
    ];
}
