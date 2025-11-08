<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;

class PerBulan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, mengikuti konvensi Laravel)
     */
    protected $table = 'per_bulans';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'guru_id',
        'daftar_gaji_path',
        'daftar_hadir_path',
        'rekening_bank_path',
        'ceklist_berkas',
        'status',
        'catatan',
    ];

    /**
     * Relasi: satu entri per_bulan dimiliki oleh satu guru.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Casting tipe data (jika diperlukan).
     */
    protected $casts = [
        'status' => 'string',
    ];
}