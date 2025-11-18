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
        if (isset($data['profile_photo_path'])) {
            $file = $data['profile_photo_path'];

            $path = FileUploads::upload($file, 'profiles', '', $data['name']);

            // generate local thumbnail
            FileUploads::generateLocalThumbnail($file, $path);

            $data['profile_photo_path'] = $path;
        }

        $data['password'] = Hash::make($data['password']);

        // Simpan user
        $user = User::create($data);

        // Jika role guru → buat relasi guru
        if ($user->role === User::ROLE_GURU) {
            $user->guru()->create([
                'nip' => $data['nip'],
                'nomor_telepon' => $data['nomor_telepon'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
            ]);

            $user->guru->sekolah()->sync($data['sekolah_id']);
        }

        // Jika role pengurus gereja → buat relasi staff_gereja
        if ($user->role === User::ROLE_STAFF_GEREJA) {
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
        if (isset($data['profile_photo_path'])) {
            // Hapus foto profil lama di Google Drive dan Lokal
            FileUploads::delete($user->profile_photo_path, true);

            $file = $data['profile_photo_path'];
            $path = FileUploads::upload($file, 'profiles', '', $data['name']);
            FileUploads::generateLocalThumbnail($file, $path);
            $data['profile_photo_path'] = $path;
        } else {
            unset($data['profile_photo_path']);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ($user->role === User::ROLE_GURU) {

            $guru = $user->guru ?: $user->guru()->create([]);

            $guru->update([
                'nip'           => $data['nip'] ?? $guru->nip,
                'tempat_lahir'  => $data['tempat_lahir'] ?? $guru->tempat_lahir,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? $guru->tanggal_lahir,
            ]);

            if (isset($data['sekolah_id'])) {
                $guru->sekolah()->updateExistingPivot($data['sekolah_id'], ['updated_at' => now()]);
            }
        }

        if ($user->role === User::ROLE_STAFF_GEREJA) {

            $staff = $user->staffGereja ?: $user->staffGereja()->create([]);

            $staff->update([
                'gembala_sidang' => $data['gembala_sidang'] ?? $staff->gembala_sidang,
                'gereja_id'      => $data['gereja_id'] ?? $staff->gereja_id,
            ]);
        }

        return $user;
    }

    /**
     * Delete a user.
     */
    public function delete(User $user)
    {
        if ($user->profile_photo_path) {
            FileUploads::delete($user->profile_photo_path, true);
        }

        if ($user->role === User::ROLE_GURU && $user->guru) {

            // Hapus pivot guru_sekolahs
            $user->guru->sekolahs()->detach();

            // Hapus data guru
            $user->guru()->delete();
        }

        if ($user->role === User::ROLE_STAFF_GEREJA && $user->staffGereja) {
            $user->staffGereja()->delete();
        }

        return $user->delete();
    }
}
