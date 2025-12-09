<?php

namespace App\Policies;

use App\Models\PerTahun;
use App\Models\User;

class PerTahunPolicy
{
    /**
     * Admin boleh lihat semua
     */
    public function viewAny(User $user): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    /**
     * Guru boleh lihat berkas miliknya sendiri
     * Admin boleh lihat semua
     */
    public function view(User $user, PerTahun $perTahun): bool
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        return $user->role === User::ROLE_GURU
            && $user->guru
            && $perTahun->guru_id === $user->guru->id;
    }

    /**
     * Guru & admin boleh membuat berkas
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_GURU]);
    }

    /**
     * Admin boleh update
     * Guru hanya boleh update berkas miliknya & status menunggu/ditolak
     */
    public function update(User $user, PerTahun $perTahun): bool
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        return $user->role === User::ROLE_GURU
            && $user->guru
            && $perTahun->guru_id === $user->guru->id
            && in_array($perTahun->status, ['menunggu', 'ditolak', 'belum lengkap']);
    }

    /**
     * Hanya admin boleh delete
     */
    public function delete(User $user, PerTahun $perTahun): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function restore(User $user, PerTahun $perTahun): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function forceDelete(User $user, PerTahun $perTahun): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }
}
