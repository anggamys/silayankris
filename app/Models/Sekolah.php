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
     * Relasi: satu sekolah memiliki banyak guru.
     */
    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }
}
