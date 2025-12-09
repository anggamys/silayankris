<?php

namespace App\Services;

use App\Models\Gereja;
use App\Utils\FileUploads;
use Illuminate\Http\UploadedFile;

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
        // Handle file upload
        if (isset($data['sertifikat_sekolah_minggu_path']) && $data['sertifikat_sekolah_minggu_path'] instanceof UploadedFile) {
            $data['sertifikat_sekolah_minggu_path'] = FileUploads::upload(
                $data['sertifikat_sekolah_minggu_path'],
                'gerejas',
                'sertifikat_sekolah_minggu',
                $data['nama']
            );
        }

        $this->prepareJsonFields($data);

        return Gereja::create($data);
    }

    /**
     * Update an existing Gereja.
     */
    public function update(Gereja $gereja, array $data): Gereja
    {
        // Handle file upload and deletion
        if (isset($data['sertifikat_sekolah_minggu_path']) && $data['sertifikat_sekolah_minggu_path'] instanceof UploadedFile) {
            // Delete old file if exists
            if ($gereja->sertifikat_sekolah_minggu_path) {
                FileUploads::delete($gereja->sertifikat_sekolah_minggu_path);
            }

            // Upload new file
            $data['sertifikat_sekolah_minggu_path'] = FileUploads::upload(
                $data['sertifikat_sekolah_minggu_path'],
                'gerejas',
                'sertifikat_sekolah_minggu',
                $data['nama']
            );
        } else {
            // Don't update file path if no new file was uploaded
            unset($data['sertifikat_sekolah_minggu_path']);
        }

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
     * Get total count of Gereja records.
     */
    public function getCountGereja(): int
    {
        return Gereja::count();
    }


    /**
     * Get gereja by user ID (for staff gereja).
     */
    public function getGerejaByUserId(string $userId): ?Gereja
    {
        return Gereja::whereHas('staffGereja', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();
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
