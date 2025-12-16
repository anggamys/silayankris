<?php

namespace App\Services;

use App\Models\User;
use App\Utils\FileUploads;
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
        // Default status selalu aktif
        $data['status'] = User::STATUS_AKTIF;

        // Upload foto profil jika ada
        if (isset($data['profile_photo_path'])) {
            $file = $data['profile_photo_path'];
            $path = FileUploads::upload($file, 'profiles', '', $data['name']);
            FileUploads::generateLocalThumbnail($file, $path);
            $data['profile_photo_path'] = $path;
        }

        // Hash password
        $data['password'] = Hash::make($data['password']);

        // SIMPAN USER
        $user = User::create($data);

        // === JIKA GURU ===
        if ($user->role === User::ROLE_GURU) {
            $guru = $user->guru()->create([
                'nik'           => $data['nik'],
                'tempat_lahir'  => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'nomor_telepon' => $data['nomor_telepon'],
            ]);

            $guru->sekolah()->sync($data['sekolah_id']);
        }

        // === JIKA STAFF GEREJA ===
        if ($user->role === User::ROLE_STAFF_GEREJA) {
            $user->staffGereja()->create([
                'gereja_id'      => $data['gereja_id'],
                'nomor_telepon'  => $data['nomor_telepon'],
            ]);
        }

        return $user;
    }

    public function update(User $user, array $data)
    {
        // Upload foto baru jika ada
        if (isset($data['profile_photo_path'])) {
            // Hapus foto lama bila ada
            if ($user->profile_photo_path) {
                FileUploads::delete($user->profile_photo_path, true);
            }

            $file = $data['profile_photo_path'];
            $path = FileUploads::upload($file, 'profiles', '', $data['name']);
            FileUploads::generateLocalThumbnail($file, $path);
            $data['profile_photo_path'] = $path;
        } else {
            unset($data['profile_photo_path']);
        }

        // Password opsional
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update user
        $user->update($data);

        // === GURU ===
        if ($user->role === User::ROLE_GURU) {
            $guru = $user->guru ?: $user->guru()->create([]);

            $guru->update([
                'nik'           => $data['nik'] ?? $guru->nik,
                'tempat_lahir'  => $data['tempat_lahir'] ?? $guru->tempat_lahir,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? $guru->tanggal_lahir,
                'nomor_telepon' => $data['nomor_telepon'] ?? $guru->nomor_telepon,
            ]);

            if (isset($data['sekolah_id'])) {
                $guru->sekolah()->sync($data['sekolah_id']);
            }
        }

        // === STAFF GEREJA ===
        if ($user->role === User::ROLE_STAFF_GEREJA) {
            $staff = $user->staffGereja ?: $user->staffGereja()->create([]);

            $staff->update([
                'gereja_id'      => $data['gereja_id'] ?? $staff->gereja_id,
                'nomor_telepon'  => $data['nomor_telepon'] ?? $staff->nomor_telepon,
            ]);
        }

        return $user;
    }


    /**
     * Delete a user.
     */
    public function delete(User $user)
    {
        // Hapus foto bila ada
        if ($user->profile_photo_path) {
            FileUploads::delete($user->profile_photo_path, true);
        }

        // Jika user adalah guru
        if ($user->role === User::ROLE_GURU && $user->guru) {

            // Aman: cek method exists dulu
            if (method_exists($user->guru, 'sekolah')) {
                $user->guru->sekolah()->detach();
            }

            // Hapus data guru
            $user->guru()->delete();
        }

        // Jika Pengurus Gereja
        if ($user->role === User::ROLE_STAFF_GEREJA && $user->staffGereja) {
            $user->staffGereja()->delete();
        }

        // Hapus user
        return $user->delete();
    }

    /**
     * Get total count of User records.
     */
    public function getCountUser(): int
    {
        return User::count();
    }
}
