<?php

namespace App\Services\Periodik;

use App\Models\PerBulan;
use App\Models\User;
use App\Utils\FileUploads;
use Illuminate\Http\UploadedFile;

class PerBulanService
{

  public function getAll(?string $search = null)
  {
      $query = PerBulan::with('guru.user');

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
              ->orWhereRaw("LOWER(periode_per_bulan) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 3. Nama bulan Inggris (June 2025) 
              // =========================================================
              ->orWhereRaw("LOWER(DATE_FORMAT(periode_per_bulan, '%M %Y')) LIKE ?", ["%{$searchLower}%"])

              // =========================================================
              // 4. Bulan angka (06-2025, 6-2025)
              // =========================================================
              ->orWhereRaw("DATE_FORMAT(periode_per_bulan, '%m-%Y') LIKE ?", ["%{$searchLower}%"])
              ->orWhereRaw("DATE_FORMAT(periode_per_bulan, '%c-%Y') LIKE ?", ["%{$searchLower}%"])

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
                          (daftar_gaji_path IS NOT NULL) +
                          (daftar_hadir_path IS NOT NULL) +
                          (rekening_bank_path IS NOT NULL) +
                          (ceklist_berkas IS NOT NULL),
                          '/',
                          4
                      ) LIKE ?
                  ", ["%{$searchLower}%"]);
              });
          });
      }

      return $query
          ->orderByDesc('periode_per_bulan')
          ->paginate(10)
          ->withQueryString();
  }

  public function store(array $data, User $user)
  {

    // Normalisasi format bulan (YYYY-MM → YYYY-MM-01)
    if (!empty($data['periode_per_bulan']) && strlen($data['periode_per_bulan']) === 7) {
        $data['periode_per_bulan'] .= '-01';
    }

    $paths = [
      'daftar_gaji_path' => 'daftar_gaji',
      'daftar_hadir_path' => 'daftar_hadir',
      'rekening_bank_path' => 'rekening_bank',
      'ceklist_berkas' => 'ceklist_berkas',
    ];

    foreach ($paths as $key => $type) {
      if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
        $data[$key] = FileUploads::upload(
          $data[$key],
          'periodik/perbulan',
          $type,
          $user->name
        );
      }
    }

    // Simpan data ke database
    return PerBulan::create($data);
  }

  public function update(array $data, PerBulan $perBulan, User $user)
  {
      // Normalisasi format bulan (YYYY-MM → YYYY-MM-01)
      if (!empty($data['periode_per_bulan']) && strlen($data['periode_per_bulan']) === 7) {
          $data['periode_per_bulan'] .= '-01';
      }

      $paths = [
          'daftar_gaji_path' => 'daftar_gaji',
          'daftar_hadir_path' => 'daftar_hadir',
          'rekening_bank_path' => 'rekening_bank',
          'ceklist_berkas' => 'ceklist_berkas',
      ];

      // Update file baru jika ada
      foreach ($paths as $key => $type) {

          if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {

              // hapus file lama
              FileUploads::delete($perBulan->$key);

              // upload baru
              $data[$key] = FileUploads::upload(
                  $data[$key],
                  'periodik/perbulan',
                  $type,
                  $user->name
              );
          } else {
              // pastikan tidak menimpa path di database
              unset($data[$key]);
          }
      }

      // Update database
      $perBulan->update($data);

      return $perBulan;
  }

  public function destroy(PerBulan $perBulan)
  {
    // Hapus file terkait
    $paths = [
      'daftar_gaji_path',
      'daftar_hadir_path',
      'rekening_bank_path',
      'ceklist_berkas',
    ];

    foreach ($paths as $path) {
      if ($perBulan->$path) {
        FileUploads::delete($perBulan->$path);
      }
    }

    // Hapus data dari database
    $perBulan->delete();
  }
}