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
    $query = PerBulan::query()
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

    foreach ($paths as $key => $type) {
      if (!empty($data[$key]) && $data[$key] instanceof UploadedFile) {
        FileUploads::delete($perBulan->$key);

        $data[$key] = FileUploads::upload(
          $data[$key],
          'periodik/perbulan',
          $type,
          $user->name
        );
      }
    }

    // Update data di database
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