<?php

namespace App\Http\Controllers\Admin\Periodik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerBulanRequest;
use App\Models\Guru;
use App\Models\PerBulan;
use App\Models\User;
use App\Services\Periodik\PerBulanService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerBulanController extends Controller
{
    protected $service;

    public function __construct(PerBulanService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', PerBulan::class);

        $search = $request->query('search');
        $perBulan = $this->service->getAll($search);

        $currentPage = $perBulan->currentPage();
        $lastPage = $perBulan->lastPage();
        $perPage = $perBulan->perPage();
        $total = $perBulan->total();

        return view('pages.admin.per-bulan.index', compact(
            'perBulan',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', PerBulan::class);

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        return view('pages.admin.per-bulan.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerBulanRequest $request)
    {
        Gate::authorize('create', PerBulan::class);

        $user = Auth::user();

        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user;
        }

        // Wajib upload minimal 1 file
        $hasFile =
            $request->hasFile('daftar_gaji_path') ||
            $request->hasFile('daftar_hadir_path') ||
            $request->hasFile('rekening_bank_path') ||
            $request->hasFile('ceklist_berkas');

        if (!$hasFile) {
            return back()->withInput()->with('error', 'Anda harus mengupload minimal 1 berkas.');
        }

        $data = $request->validated();

        // Masukkan UploadedFile ke data
        foreach (['daftar_gaji_path', 'daftar_hadir_path', 'rekening_bank_path', 'ceklist_berkas'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey);
            }
        }

        // Periode → YYYY-MM-01
        if (!empty($data['periode_per_bulan']) && strlen($data['periode_per_bulan']) === 7) {
            $data['periode_per_bulan'] .= '-01';
        }

        // ==============================
        // STATUS OTOMATIS
        // ==============================
        $uploadedCount = collect([
            $request->file('daftar_gaji_path'),
            $request->file('daftar_hadir_path'),
            $request->file('rekening_bank_path'),
            $request->file('ceklist_berkas'),
        ])->filter()->count();

        $data['status'] = $uploadedCount < 4
            ? 'belum lengkap'
            : 'diterima';

        // Simpan data
        $this->service->store($data, $user);

        return redirect()->route('admin.per-bulan.index')
            ->with('success', 'Data per bulan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerBulan $perBulan)
    {
        Gate::authorize('view', $perBulan);

        $perBulan->load('guru.user');

        return view('pages.admin.per-bulan.show', compact('perBulan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        $perBulan->load('guru.user');

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        // ============================================
        // CEK KELENGKAPAN FILE (0–4 file)
        // ============================================
        $uploaded = collect([
            $perBulan->daftar_gaji_path,
            $perBulan->daftar_hadir_path,
            $perBulan->rekening_bank_path,
            $perBulan->ceklist_berkas,
        ])->filter()->count();

        // Jika file belum lengkap → hanya boleh status "belum lengkap"
        // Jika file lengkap → semua opsi muncul
        $statusOptions = $uploaded < 4
            ? ['belum lengkap' => 'Belum Lengkap']
            : [
                'menunggu' => 'Menunggu',
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak',
                'belum lengkap' => 'Belum Lengkap',
            ];

        // Kirim ke Blade
        return view('pages.admin.per-bulan.edit', compact('perBulan', 'gurus', 'statusOptions'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PerBulanRequest $request, PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        $user = Auth::user();

        // Jika admin, data akan dimiliki oleh user milik guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user;
        }

        // Ambil data validasi
        $data = $request->validated();

        // Gabungkan file upload
        foreach (['daftar_gaji_path', 'daftar_hadir_path', 'rekening_bank_path', 'ceklist_berkas'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey);
            }
        }

        // Update berkas & data lain
        $this->service->update($data, $perBulan, $user);

        // =====================================================
        // LOGIKA STATUS DINAMIS (BERDASARKAN KELENGKAPAN FILE)
        // =====================================================

        // Refresh agar isi model terupdate dari database
        $perBulan->refresh();

        // Hitung jumlah file lengkap
        $uploaded = collect([
            $perBulan->daftar_gaji_path,
            $perBulan->daftar_hadir_path,
            $perBulan->rekening_bank_path,
            $perBulan->ceklist_berkas,
        ])->filter()->count();

        // Jika file belum lengkap → status otomatis "belum lengkap"
        if ($uploaded < 4) {
            $perBulan->status = 'belum lengkap';
        }
        // Jika file lengkap → gunakan pilihan admin (menunggu / diterima / ditolak)
        else {
            $perBulan->status = $request->status;
        }

        $perBulan->save();

        return redirect()->route('admin.per-bulan.index')
            ->with('success', 'Data per bulan berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerBulan $perBulan)
    {
        Gate::authorize('delete', $perBulan);

        $this->service->destroy($perBulan);

        return redirect()->route('admin.per-bulan.index')
            ->with('success', 'Data per bulan berhasil dihapus');
    }
}
