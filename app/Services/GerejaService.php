<?php

namespace App\Services;

use App\Models\Gereja;

class GerejaService
{
    /**
     * Get all gereja with optional search.
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

        return $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Store a new Gereja.
     */
    public function store(array $data): Gereja
    {
        $this->prepareJsonFields($data);

        return Gereja::create($data);
    }

    /**
     * Update an existing Gereja.
     */
    public function update(Gereja $gereja, array $data): Gereja
    {
        $this->prepareJsonFields($data);

        $gereja->update($data);

        return $gereja;
    }

    /**
     * Delete gereja
     */
    public function delete(Gereja $gereja): bool
    {
        return $gereja->delete();
    }

    /**
     * Format JSON fields before saving.
     */
    private function prepareJsonFields(array &$data): void
    {
        $jsonFields = [
            'jumlah_umat',
            'jumlah_majelis',
            'jumlah_pemuda',
            'jumlah_guru_sekolah_minggu',
            'jumlah_murid_sekolah_minggu',
        ];

        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = [
                    'laki_laki' => $data[$field]['laki_laki'] ?? 0,
                    'perempuan' => $data[$field]['perempuan'] ?? 0,
                ];
            }
        }
    }
}
