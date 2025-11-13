<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get all users with optional search.
     */
    public function getAll(?string $search = null)
    {
        $query = User::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', $search);
            });
        }
        return $query->paginate(10)->withQueryString();
    }

    /**
     * Store a new user.
     */
    public function store(array $data)
    {
        if (isset($data['profile_path'])) {
            $data['profile_path'] = $data['profile_path']->store('profiles', 'public');
        }

        $data['password'] = Hash::make($data['password']);

        // Simpan user
        $user = User::create($data);

        // Jika role guru → buat relasi guru
        if ($user->role === User::ROLE_GURU) {
            $user->guru()->create([
                'sekolah_id' => $data['sekolah_id'],
                'nip' => $data['nip'],
                'nomor_telepon' => $data['nomor_telepon'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
            ]);
        }

        // Jika role pengurus gereja → buat relasi staff_gereja
        if ($user->role === User::ROLE_PENGURUS_GEREJA) {
            $user->staffGereja()->create([
                'gembala_sidang' => $data['gembala_sidang'],
                'nomor_telepon' => $data['nomor_telepon'],
                'gereja_id' => $data['gereja_id'],
            ]);
        }
        return $user;
    }

    /**
     * Update an existing user.
     */
    public function update(User $user, array $data)
    {
        if (isset($data['profile_path'])) {
            $data['profile_path'] = $data['profile_path']->store('profiles', 'public');
        } else {
            unset($data['profile_path']);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     */
    public function delete(User $user)
    {
        return $user->delete();
    }
}
