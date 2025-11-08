<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Gereja;

class StaffGereja extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional, mengikuti konvensi Laravel)
     */
    protected $table = 'staff_gerejas';

    /**
     * Kolom yang bisa diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'gembala_sidang',
        'nomor_telepon',
        'gereja_id',
    ];

    /**
     * Relasi: setiap staff gereja terhubung dengan satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: setiap staff gereja bekerja di satu gereja.
     */
    public function gereja()
    {
        return $this->belongsTo(Gereja::class);
    }
}
