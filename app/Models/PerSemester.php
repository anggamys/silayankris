<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;

class PerSemester extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional jika mengikuti konvensi Laravel)
     */
    protected $table = 'per_semesters';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'guru_id',
        'sk_pbm_path',
        'sk_terakhir_path',
        'sk_berkala_path',
        'sp_bersedia_mengembalikan_path',
        'sp_perangkat_pembelajaran_path',
        'keaktifan_simpatika_path',
        'berkas_s28a_path',
        'berkas_skmt_path',
        'permohonan_skbk_path',
        'berkas_skbk_path',
        'sertifikat_pengembangan_diri_path',
        'status',
        'catatan',
    ];

    /**
     * Relasi: satu entri per_semester dimiliki oleh satu guru.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Casting tipe data tertentu.
     */
    protected $casts = [
        'status' => 'string',
    ];
}
