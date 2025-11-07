<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional jika sesuai konvensi Laravel).
     */
    protected $table = 'beritas';

    /**
     * Kolom yang bisa diisi (mass assignment).
     */
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'gambar_path',
    ];

    /**
     * Relasi ke model User (Many-to-One).
     * Satu berita dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
