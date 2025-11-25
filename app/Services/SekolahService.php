<?php

namespace App\Services;

use App\Models\Sekolah;
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
    public function update(Sekolah $sekolah, array $data)
    {
        // If there's a password in the payload, hash it; otherwise remove it so we don't set an empty password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $sekolah->update($data);

        return $sekolah;
    }

    /**
     * Delete a sekolah.
     */
    public function delete(Sekolah $sekolah): void
    {
        $sekolah->delete();
    }
}
