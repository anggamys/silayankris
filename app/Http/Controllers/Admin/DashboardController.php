<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BeritaService;
use App\Services\GerejaService;
use App\Services\Periodik\PerBulanService;
use App\Services\Periodik\PerSemesterService;
use App\Services\Periodik\PerTahunService;
use App\Services\SekolahService;
use App\Services\UserService;

class DashboardController extends Controller
{
  public function __construct(
    protected UserService $userService,
    protected BeritaService $beritaService,
    protected GerejaService $gerejaService,
    protected SekolahService $sekolahService,
    protected PerBulanService $perBulanService,
    protected PerSemesterService $perSemesterService,
    protected PerTahunService $perTahunService,
  ) {}
    public function index()
    {
    $stats = [
      'users'        => $this->userService->getCountUser(),
      'gereja'       => $this->gerejaService->getCountGereja(),
      'sekolah'      => $this->sekolahService->getCountSekolah(),
      'berita'       => $this->beritaService->getCountBerita(),
      'per_bulan'    => $this->perBulanService->getCountPerBulan(),
      'per_semester' => $this->perSemesterService->getCountOfPerSemester(),
      'per_tahun'    => $this->perTahunService->getCountPertahun(),
    ];
    return view('pages.admin.dashboard', compact('stats'));
    }
}
