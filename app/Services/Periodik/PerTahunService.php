<?php

namespace App\Services\Periodik;

use App\Models\PerTahun;
use App\Models\User;
use App\Utils\FileUploads;
use Illuminate\Http\UploadedFile;

class PerTahunService
{

    public function getAll(?string $search = null)
    {
        $query = PerTahun::query()
            ->with('guru.user');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->WhereHas('guru.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
            });
        }
        return $query->orderByDesc('updated_at')
            ->paginate(10)->withQueryString();
    }

    public function store(array $data, User $user)
    {
        $paths = [
            'biodata_path' => 'biodata',
            'sertifikat_pendidik_path' => 'sertifikat_pendidik',
            'sk_dirjen_path' => 'sk_dirjen',
            'sk_kelulusan_path' => 'sk_kelulusan',
            'nrg_path' => 'nrg',
            'nuptk_path' => 'nuptk',
            'npwp_path' => 'npwp',
            'ktp_path' => 'ktp',
            'ijazah_sd_path' => 'ijazah_sd',
            'ijazah_smp_path' => 'ijazah_smp',
            'ijazah_sma_path' => 'ijazah_sma',
            'sk_pns_path' => 'sk_pns',
            'sk_gty_path' => 'sk_gty',
            'ijazah_s1_path' => 'ijazah_s1',
            'transkrip_nilai_s1_path' => 'transkrip_nilai_s1',
        ];

        foreach ($paths as $key => $type) {
            if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
                $data[$key] = FileUploads::upload(
                    $data[$key],
                    'periodik/pertahun',
                    $type,
                    $user->name
                );
            }
        }

        // Simpan data ke database
        return PerTahun::create($data);
    }

    public function update(array $data, PerTahun $perTahun, User $user)
    {
        $paths = [
            'biodata_path' => 'biodata',
            'sertifikat_pendidik_path' => 'sertifikat_pendidik',
            'sk_dirjen_path' => 'sk_dirjen',
            'sk_kelulusan_path' => 'sk_kelulusan',
            'nrg_path' => 'nrg',
            'nuptk_path' => 'nuptk',
            'npwp_path' => 'npwp',
            'ktp_path' => 'ktp',
            'ijazah_sd_path' => 'ijazah_sd',
            'ijazah_smp_path' => 'ijazah_smp',
            'ijazah_sma_path' => 'ijazah_sma',
            'sk_pns_path' => 'sk_pns',
            'sk_gty_path' => 'sk_gty',
            'ijazah_s1_path' => 'ijazah_s1',
            'transkrip_nilai_s1_path' => 'transkrip_nilai_s1',
        ];

        foreach ($paths as $key => $type) {
            if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
                FileUploads::delete($perTahun->$key);

                $data[$key] = FileUploads::upload(
                    $data[$key],
                    'periodik/pertahun',
                    $type,
                    $user->name
                );
            }
        }

        // Update data di database
        $perTahun->update($data);

        return $perTahun;

    }

    public function destroy(PerTahun $perTahun)
    {
        // Hapus file terkait
        $paths = [
            'biodata_path',
            'sertifikat_pendidik_path',
            'sk_dirjen_path',
            'sk_kelulusan_path',
            'nrg_path',
            'nuptk_path',
            'npwp_path',
            'ktp_path',
            'ijazah_sd_path',
            'ijazah_smp_path',
            'ijazah_sma_path',
            'sk_pns_path',
            'sk_gty_path',
            'ijazah_s1_path',
            'transkrip_nilai_s1_path',
        ];

        foreach ($paths as $path) {
            if ($perTahun->$path) {
                FileUploads::delete($perTahun->$path);
            }
        }

        // Hapus data dari database
        $perTahun->delete();
    }
}