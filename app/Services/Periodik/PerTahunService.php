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
      $query = PerTahun::with('guru.user');

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
              ->orWhereRaw("LOWER(periode_per_tahun) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 3. Nama bulan Inggris (June 2025) 
              // =========================================================
              ->orWhereRaw("LOWER(DATE_FORMAT(periode_per_tahun, '%M %Y')) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 4. Bulan angka (06-2025, 6-2025)
              // =========================================================
              ->orWhereRaw("DATE_FORMAT(periode_per_tahun, '%m-%Y') LIKE ?", ["%{$searchLower}%"])
              ->orWhereRaw("DATE_FORMAT(periode_per_tahun, '%c-%Y') LIKE ?", ["%{$searchLower}%"])

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
                          (biodata_path IS NOT NULL) +
                          (sertifikat_pendidik_path IS NOT NULL) +
                          (sk_dirjen_kelulusan_path IS NOT NULL) +
                          (nrg_path IS NOT NULL) +
                          (nuptk_path IS NOT NULL) +
                          (npwp_path IS NOT NULL) +
                          (ktp_path IS NOT NULL) +
                          (ijazah_sd_path IS NOT NULL) +
                          (ijazah_smp_path IS NOT NULL) +
                          (ijazah_sma_pga_path IS NOT NULL) +
                          (sk_pns_gty_path IS NOT NULL) +
                          (ijazah_s1_path IS NOT NULL) +
                          (transkrip_nilai_s1_path IS NOT NULL),
                          '/',
                          13
                      ) LIKE ?
                  ", ["%{$searchLower}%"]);
              });
          });
      }

      return $query
          ->orderByDesc('periode_per_tahun')
          ->paginate(10)
          ->withQueryString();
  }

  public function store(array $data, User $user)
  {

    // Normalisasi format tahun: YYYY → YYYY-01-01
    if (!empty($data['periode_per_tahun'])) {
        $tahun = $data['periode_per_tahun'];
        // Jika hanya tahun (4 digit), convert ke YYYY-01-01
        if (strlen($tahun) === 4 && is_numeric($tahun)) {
            $data['periode_per_tahun'] = $tahun . '-01-01';
        }
        // Jika format YYYY-MM (7 digit), convert ke YYYY-MM-01
        elseif (strlen($tahun) === 7) {
            $data['periode_per_tahun'] = $tahun . '-01';
        }
    }

    $paths = [
    'biodata_path' => 'biodata',
    'sertifikat_pendidik_path' => 'sertifikat_pendidik',
    'sk_dirjen_kelulusan_path' => 'sk_dirjen_kelulusan',
    'nrg_path' => 'nrg',
    'nuptk_path' => 'nuptk',
    'npwp_path' => 'npwp',
    'ktp_path' => 'ktp',
    'ijazah_sd_path' => 'ijazah_sd',
    'ijazah_smp_path' => 'ijazah_smp',
    'ijazah_sma_pga_path' => 'ijazah_sma_pga',
    'sk_pns_gty_path' => 'sk_pns_gty',
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
      // Normalisasi format tahun: YYYY → YYYY-01-01
      if (!empty($data['periode_per_tahun'])) {
          $tahun = $data['periode_per_tahun'];
          // Jika hanya tahun (4 digit), convert ke YYYY-01-01
          if (strlen($tahun) === 4 && is_numeric($tahun)) {
              $data['periode_per_tahun'] = $tahun . '-01-01';
          }
          // Jika format YYYY-MM (7 digit), convert ke YYYY-MM-01
          elseif (strlen($tahun) === 7) {
              $data['periode_per_tahun'] = $tahun . '-01';
          }
      }

      $paths = [
          'daftar_gaji_path' => 'daftar_gaji',
          'daftar_hadir_path' => 'daftar_hadir',
          'rekening_bank_path' => 'rekening_bank',
          'ceklist_berkas' => 'ceklist_berkas',
          'biodata_path' => 'biodata',
          'sertifikat_pendidik_path' => 'sertifikat_pendidik',
          'sk_dirjen_kelulusan_path' => 'sk_dirjen_kelulusan',
          'nrg_path' => 'nrg',
          'nuptk_path' => 'nuptk',
          'npwp_path' => 'npwp',
          'ktp_path' => 'ktp',
          'ijazah_sd_path' => 'ijazah_sd',
          'ijazah_smp_path' => 'ijazah_smp',
          'ijazah_sma_pga_path' => 'ijazah_sma_pga',
          'sk_pns_gty_path' => 'sk_pns_gty',
          'ijazah_s1_path' => 'ijazah_s1',
          'transkrip_nilai_s1_path' => 'transkrip_nilai_s1',
      ];

      // Update file baru jika ada
      foreach ($paths as $key => $type) {

          if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {

              // hapus file lama
              FileUploads::delete($perTahun->$key);

              // upload baru
              $data[$key] = FileUploads::upload(
                  $data[$key],
                  'periodik/pertahun',
                  $type,
                  $user->name
              );
          } else {
              // pastikan tidak menimpa path di database
              unset($data[$key]);
          }
      }

      // Update database
      $perTahun->update($data);

      return $perTahun;
  }

  public function destroy(PerTahun $perTahun)
  {
    // Hapus file terkait
    $paths = [
    'daftar_gaji_path',
    'daftar_hadir_path',
    'rekening_bank_path',
    'ceklist_berkas',
    'biodata_path',
    'sertifikat_pendidik_path',
    'sk_dirjen_kelulusan_path',
    'nrg_path',
    'nuptk_path',
    'npwp_path',
    'ktp_path',
    'ijazah_sd_path',
    'ijazah_smp_path',
    'ijazah_sma_pga_path',
    'sk_pns_gty_path',
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

  /**
   * Get total count of PerTahun records.
   */
  public function getCountPerTahun(): int
  {
      return PerTahun::count();
  }
}