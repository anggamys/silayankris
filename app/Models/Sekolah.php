<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;

class Sekolah extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, sesuai konvensi Laravel)
     */
    protected $table = 'sekolahs';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'alamat',
    ];

    /**
     * Relasi: satu sekolah bisa memiliki banyak guru (many-to-many).
     */
    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_sekolahs')->withTimestamps();
    }
}
