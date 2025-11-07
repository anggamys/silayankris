<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Sekolah;

class Guru extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, mengikuti konvensi Laravel)
     */
    protected $table = 'gurus';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'sekolah_id',
        'user_id',
        'nip',
        'nomor_telepon',
        'tempat_lahir',
        'tanggal_lahir',
    ];

    /**
     * Casting untuk tipe data tertentu.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi: satu guru dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: satu guru bekerja di satu sekolah.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
