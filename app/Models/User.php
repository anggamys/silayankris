<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Guru;
use App\Models\StaffGereja;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tipe primary key: UUID.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * Kolom yang disembunyikan saat model dikonversi ke array atau JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data untuk kolom tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: User bisa menjadi guru.
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Relasi: User bisa menjadi staff gereja.
     */
    public function staffGereja()
    {
        return $this->hasOne(StaffGereja::class);
    }
}
