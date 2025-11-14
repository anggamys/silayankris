<?php

namespace App\Services\Periodik;

use App\Models\PerBulan;
use App\Models\User;
use App\Utils\FileUploads;

class PerBulanService
{

  public function getAll(?string $search = null)
  {
    $query = PerBulan::query();
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('bulan', 'like', "%$search%")
          ->orWhere('tahun', 'like', "%$search%");
      });
    }
    return $query->orderByDesc('updated_at')
      ->paginate(10)->withQueryString();
  }

  public function store(array $data, User $user)
  {
    $paths = [
      'daftar_gaji_path' => 'daftar_gaji',
      'daftar_hadir_path' => 'daftar_hadir',
      'rekening_bank_path' => 'rekening_bank',
    ];

    foreach ($paths as $key => $type) {
      if (!empty($data[$key])) {
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
}
