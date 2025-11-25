<?php

namespace App\Services\Periodik;

use App\Models\PerSemester;
use App\Models\User;
use App\Utils\FileUploads;
use Illuminate\Http\UploadedFile;

class PerSemesterService
{

  public function getAll(?string $search = null)
  {
    $query = PerSemester::query()
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
      'sk_pbm_path' => 'sk_pbm',
      'sk_terakhir_path' => 'sk_terakhir',
      'sk_berkala_path' => 'sk_berkala',
      'sp_bersedia_mengembalikan_path' => 'sp_bersedia_mengembalikan',
      'sp_perangkat_pembelajaran_path' => 'sp_perangkat_pembelajaran',
      'keaktifan_simpatika_path' => 'keaktifan_simpatika',
      'berkas_s28a_path' => 'berkas_s28a',
      'berkas_skmt_path' => 'berkas_skmt',
      'permohonan_skbk_path' => 'permohonan_skbk',
      'berkas_skbk_path' => 'berkas_skbk',
      'sertifikat_pengembangan_diri_path' => 'sertifikat_pengembangan_diri',
    ];

    foreach ($paths as $key => $type) {
      if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
        $data[$key] = FileUploads::upload(
          $data[$key],
          'periodik/persemester',
          $type,
          $user->name
        );
      }
    }

    // Simpan data ke database
    return PerSemester::create($data);
  }

  public function update(array $data, PerSemester $perSemester, User $user)
  {
    $paths = [
      'sk_pbm_path' => 'sk_pbm',
      'sk_terakhir_path' => 'sk_terakhir',
      'sk_berkala_path' => 'sk_berkala',
      'sp_bersedia_mengembalikan_path' => 'sp_bersedia_mengembalikan',
      'sp_perangkat_pembelajaran_path' => 'sp_perangkat_pembelajaran',
      'keaktifan_simpatika_path' => 'keaktifan_simpatika',
      'berkas_s28a_path' => 'berkas_s28a',
      'berkas_skmt_path' => 'berkas_skmt',
      'permohonan_skbk_path' => 'permohonan_skbk',
      'berkas_skbk_path' => 'berkas_skbk',
      'sertifikat_pengembangan_diri_path' => 'sertifikat_pengembangan_diri',
    ];

    foreach ($paths as $key => $type) {
      if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
        FileUploads::delete($perSemester->$key);

        $data[$key] = FileUploads::upload(
          $data[$key],
          'periodik/persemester',
          $type,
          $user->name
        );
      }
    }

    // Update data di database
    $perSemester->update($data);

    return $perSemester;

  }

  public function destroy(PerSemester $perSemester)
  {
    // Hapus file terkait
    $paths = [
      'sk_pbm_path',
      'sk_terakhir_path',
      'sk_berkala_path',
      'sp_bersedia_mengembalikan_path',
      'sp_perangkat_pembelajaran_path',
      'keaktifan_simpatika_path',
      'berkas_s28a_path',
      'berkas_skmt_path',
      'permohonan_skbk_path',
      'berkas_skbk_path',
      'sertifikat_pengembangan_diri_path',
    ];

    foreach ($paths as $path) {
      if ($perSemester->$path) {
        FileUploads::delete($perSemester->$path);
      }
    }

    // Hapus data dari database
    $perSemester->delete();
  }
}