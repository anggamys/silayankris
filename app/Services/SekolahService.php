<?php

namespace App\Services;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SekolahService
{
    /**
     * Get all sekolah with optional search.
     */
    public function getAll(?string $search = null)
    {
        $query = Sekolah::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%");
            });
        }
        return $query->paginate(10)->withQueryString();
    }

    /**
     * Store a new sekolah.
     */
    public function store(array $data)
    {
        return Sekolah::create($data);
    }

    /**
     * Update an existing sekolah.
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
