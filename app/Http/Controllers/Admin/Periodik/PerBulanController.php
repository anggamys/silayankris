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

        // Use validated data and include uploaded files so the service
        // receives UploadedFile instances (prevents saving temp php*.tmp names).
        $data = $request->validated();

        // Merge uploaded files into data array if present
        foreach (['daftar_gaji_path', 'daftar_hadir_path', 'rekening_bank_path', 'ceklist_berkas'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey);
            }
        }

        // FIX format periode (YYYY-MM → YYYY-MM-01)
        if (!empty($data['periode_per_bulan']) && strlen($data['periode_per_bulan']) === 7) {
            $data['periode_per_bulan'] .= '-01';
        }

        $this->service->store($data, $user);

        return redirect()->route('admin.per-bulan.index')->with('success', 'Data per bulan berhasil disimpan');
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

        return view('pages.admin.per-bulan.edit', compact('perBulan', 'gurus'));
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

        // Hitung jumlah file lengkap
        $uploaded = collect([
            $perBulan->daftar_gaji_path,
            $perBulan->daftar_hadir_path,
            $perBulan->rekening_bank_path,
            $perBulan->ceklist_berkas,
        ])->filter()->count();

        // Tentukan status otomatis
        if ($uploaded < 4) {
            // FILE BELUM LENGKAP
            $perBulan->status = 'belum lengkap';
        } else {
            // FILE LENGKAP → pakai input admin
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
