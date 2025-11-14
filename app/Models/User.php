<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\Guru;
use App\Models\StaffGereja;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * Tipe primary key: UUID.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_GURU = 'guru';
    public const ROLE_STAFF_GEREJA = 'staff-gereja';

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_NONAKTIF = 'nonaktif';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_path',
        'nomor_telepon',
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
