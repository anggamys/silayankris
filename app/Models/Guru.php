<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\PerBulan;
use App\Models\PerSemester;

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
        'user_id',
        'nip',
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
     * Relasi: satu guru bisa memiliki banyak sekolah.
     */
    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'guru_sekolahs')->withTimestamps();
    }

    /**
     * Relasi: setiap guru terhubung dengan satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: satu guru punya banyak PerBulan (berkas bulanan).
     */
    public function perBulans()
    {
        return $this->hasMany(PerBulan::class, 'guru_id');
    }

    /**
     * Relasi: satu guru punya banyak PerSemester (berkas semester).
     */
    public function perSemesters()
    {
        return $this->hasMany(PerSemester::class, 'guru_id');
    }
}
