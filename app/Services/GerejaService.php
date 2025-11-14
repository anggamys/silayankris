<?php

namespace App\Services;

use App\Models\Berita;
use App\Models\Gereja;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GerejaService
{
    /**
     * Get all users with optional search.
     */
    public function getAll(?string $search = null)
    {
        $query = Gereja::with('staffGereja.user');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('kab_kota', 'like', "%$search%")
                    ->orWhere('id', $search);
            });
        }
        return $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
    }

    /**
     * Store a new user.
     */
    public function store(array $data)
    {

        if (isset($data['gambar_path'])) {
            $data['gambar_path'] = $data['gambar_path']->store('beritas', 'public');
        }
        return Berita::create($data);
    }

    /**
     * Update an existing user.
     */
    public function update(Berita $berita, array $data)
{
    if (isset($data['gambar_path'])) {
        // Hapus gambar lama jika ada
        if ($berita->gambar_path && Storage::disk('public')->exists($berita->gambar_path)) {
            Storage::disk('public')->delete($berita->gambar_path);
        }

        // Simpan gambar baru
        $data['gambar_path'] = $data['gambar_path']->store('beritas', 'public');
    } else {
        unset($data['gambar_path']);
    }

    $berita->update($data);
    return $berita;
}

    /**
     * Delete a user.
     */
    public function delete(Berita $berita)
    {
        return $berita->delete();
    }
}
