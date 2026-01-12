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
        if (isset($data['piagam_sekolah_minggu_path']) && $data['piagam_sekolah_minggu_path'] instanceof UploadedFile) {
            $data['piagam_sekolah_minggu_path'] = FileUploads::upload(
                $data['piagam_sekolah_minggu_path'],
                'gerejas',
                'piagam_sekolah_minggu',
                $data['nama']
            );
        }

        // Filter empty pendeta names
        if (isset($data['nama_pendeta']) && is_array($data['nama_pendeta'])) {
            $data['nama_pendeta'] = array_filter($data['nama_pendeta'], function ($name) {
                return !empty(trim($name));
            });
            if (empty($data['nama_pendeta'])) {
                $data['nama_pendeta'] = null;
            }
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
        if (isset($data['piagam_sekolah_minggu_path']) && $data['piagam_sekolah_minggu_path'] instanceof UploadedFile) {
            // Delete old file if exists
            if ($gereja->piagam_sekolah_minggu_path) {
                FileUploads::delete($gereja->piagam_sekolah_minggu_path);
            }

            // Upload new file
            $data['piagam_sekolah_minggu_path'] = FileUploads::upload(
                $data['piagam_sekolah_minggu_path'],
                'gerejas',
                'piagam_sekolah_minggu',
                $data['nama']
            );
        } else {
            // Don't update file path if no new file was uploaded
            unset($data['piagam_sekolah_minggu_path']);
        }

        // Filter empty pendeta names
        if (isset($data['nama_pendeta']) && is_array($data['nama_pendeta'])) {
            $data['nama_pendeta'] = array_filter($data['nama_pendeta'], function ($name) {
                return !empty(trim($name));
            });
            if (empty($data['nama_pendeta'])) {
                $data['nama_pendeta'] = null;
            }
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
            'jumlah_majelis_pendeta',
            'jumalah_majelis_penetua',
            'jumlah_majelis_diaken',
            'jumlah_majelis_tua_jamaat',
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
