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
      $query = PerSemester::with('guru.user');

      if ($search) {
          $searchLower = strtolower($search);

          $query->where(function ($q) use ($searchLower) {

              // =========================================================
              // 1. Nama Guru
              // =========================================================
              $q->whereHas('guru.user', function ($u) use ($searchLower) {
                  $u->whereRaw("LOWER(name) LIKE ?", ["%{$searchLower}%"]);
              })

              // =========================================================
              // 2. Periode (raw: YYYY-MM-01)
              // =========================================================
              ->orWhereRaw("LOWER(periode_per_semester) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 3. Semester (-) 
              // =========================================================
              ->orWhereRaw("LOWER(DATE_FORMAT(periode_per_semester, '%M %Y')) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 4. Bulan angka (06-2025, 6-2025)
              // =========================================================
              ->orWhereRaw("DATE_FORMAT(periode_per_semester, '%m-%Y') LIKE ?", ["%{$searchLower}%"])
              ->orWhereRaw("DATE_FORMAT(periode_per_semester, '%c-%Y') LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 5. Status
              // =========================================================
              ->orWhereRaw("LOWER(status) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 6. Tanggal dibuat (03 Dec 2025)
              // =========================================================
              ->orWhereRaw("LOWER(DATE_FORMAT(created_at, '%d %M %Y')) LIKE ?", ["%{$searchLower}%"])

              // Support format lain seperti "03 dec", "3 dec"
              ->orWhereRaw("LOWER(DATE_FORMAT(created_at, '%d %b %Y')) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 7. Progress Upload (misal: "3/4", "4/4")
              // =========================================================
              ->orWhere(function ($q2) use ($searchLower) {
                  $q2->whereRaw("
                      CONCAT(
                          (sk_pbm_path IS NOT NULL) +
                          (sk_terakhir_path IS NOT NULL) +
                          (sk_berkala_path IS NOT NULL) +
                          (sp_bersedia_mengembalikan_path IS NOT NULL) +
                          (sp_kebenaran_berkas_path IS NOT NULL) +
                          (sp_perangkat_pembelajaran_path IS NOT NULL) +
                          (keaktifan_simpatika_path IS NOT NULL) +
                          (berkas_s28a_path IS NOT NULL) +
                          (berkas_skmt_path IS NOT NULL) +
                          (permohonan_skbk_path IS NOT NULL) +
                          (berkas_skbk_path IS NOT NULL) +
                          (sertifikat_pengembangan_diri_path IS NOT NULL),
                          '/',
                          12
                      ) LIKE ?
                  ", ["%{$searchLower}%"]);
              });
          });
      }

      return $query
          ->orderByDesc('periode_per_semester')
          ->paginate(10)
          ->withQueryString();
  }

  public function store(array $data, User $user)
  {

    // Normalisasi format bulan (YYYY-MM → YYYY-MM-01)
    if (!empty($data['periode_per_semester']) && strlen($data['periode_per_semester']) === 7) {
        $data['periode_per_semester'] .= '-01';
    }

    $paths = [
      'sk_pbm_path' => 'sk_pbm',
      'sk_terakhir_path' => 'sk_terakhir',
      'sk_berkala_path' => 'sk_berkala',
      'sp_bersedia_mengembalikan_path' => 'sp_bersedia_mengembalikan',
      'sp_kebenaran_berkas_path' => 'sp_kebenaran_berkas',
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
      // Normalisasi format bulan (YYYY-MM → YYYY-MM-01)
      if (!empty($data['periode_per_semester']) && strlen($data['periode_per_semester']) === 7) {
          $data['periode_per_semester'] .= '-01';
      }

      $paths = [
          'sk_pbm_path' => 'sk_pbm',
          'sk_terakhir_path' => 'sk_terakhir',
          'sk_berkala_path' => 'sk_berkala',
          'sp_bersedia_mengembalikan_path' => 'sp_bersedia_mengembalikan',
          'sp_kebenaran_berkas_path' => 'sp_kebenaran_berkas',
          'sp_perangkat_pembelajaran_path' => 'sp_perangkat_pembelajaran',
          'keaktifan_simpatika_path' => 'keaktifan_simpatika',
          'berkas_s28a_path' => 'berkas_s28a',
          'berkas_skmt_path' => 'berkas_skmt',
          'permohonan_skbk_path' => 'permohonan_skbk',
          'berkas_skbk_path' => 'berkas_skbk',
          'sertifikat_pengembangan_diri_path' => 'sertifikat_pengembangan_diri',
      ];

      // Update file baru jika ada
      foreach ($paths as $key => $type) {

          if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {

              // hapus file lama
              FileUploads::delete($perSemester->$key);

              // upload baru
              $data[$key] = FileUploads::upload(
                  $data[$key],
                  'periodik/persemester',
                  $type,
                  $user->name
              );
          } else {
              // pastikan tidak menimpa path di database
              unset($data[$key]);
          }
      }

      // Update database
      $perSemester->update($data);

      return $perSemester;
  }

  public function destroy(PerSemester $perSemester)
  {
    // Hapus file terkait
    $paths = [
      'daftar_gaji_path',
      'sk_pbm_path',
      'sk_terakhir_path',
      'sk_berkala_path',
      'sp_bersedia_mengembalikan_path',
      'sp_kebenaran_berkas_path',
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