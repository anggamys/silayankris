<?php

namespace App\Http\Controllers\User\Periodik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerBulanRequest;
use App\Models\PerBulan;
use App\Services\Periodik\PerBulanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PerBulanUserController extends Controller
{
    protected $service;

    public function __construct(PerBulanService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    // ================================
    // INDEX / RIWAYAT
    // ================================
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return back()->with('error', 'Anda belum terhubung sebagai guru.');
        }

        // Ambil data dengan pagination 5 per halaman
        $items = $guru->perBulans()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // Data untuk pagination info
        $currentPage = $items->currentPage();
        $lastPage    = $items->lastPage();
        $perPage     = $items->perPage();
        $total       = $items->total();

        return view('pages.user.per-bulan.index', compact(
            'items',
            'user',
            'guru',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }


    // ================================
    // FORM UPLOAD
    // ================================
    public function create()
    {
        return view('pages.user.per-bulan.create');
    }

    // ================================
    // STORE DATA
    // ================================

    public function store(PerBulanRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return back()->with('error', 'Anda belum terhubung sebagai guru.');
        }

        // =====================================
        // VALIDASI WAJIB: Minimal upload 1 file
        // =====================================
        $hasFile =
            $request->hasFile('daftar_gaji_path') ||
            $request->hasFile('daftar_hadir_path') ||
            $request->hasFile('rekening_bank_path') ||
            $request->hasFile('ceklist_berkas');

        if (!$hasFile) {
            return back()->withInput()->with('error', 'Anda harus mengupload minimal 1 berkas.');
        }

        try {
            // Set guru_id
            $validated['guru_id'] = $guru->id;

            // Tentukan status awal (lengkap / belum lengkap)
            $files = [
                $validated['daftar_gaji_path'] ?? null,
                $validated['daftar_hadir_path'] ?? null,
                $validated['rekening_bank_path'] ?? null,
                $validated['ceklist_berkas'] ?? null,
            ];

            $validated['status'] = in_array(null, $files)
                ? 'belum lengkap'
                : 'menunggu';

            // Merge UploadedFile instances into validated data so the service
            // receives real UploadedFile objects instead of PHP temp names.
            foreach (['daftar_gaji_path', 'daftar_hadir_path', 'rekening_bank_path', 'ceklist_berkas'] as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $validated[$fileKey] = $request->file($fileKey);
                }
            }

            $this->service->store($validated, $user);

            return redirect()->route('user.perbulan.index')
                ->with('success', 'Berkas bulanan berhasil diunggah.');

        } catch (\Throwable $e) {
            Log::error('PerBulanUser store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan.');
        }
    }


    // ================================
    // DETAIL
    // ================================
    public function show(PerBulan $perBulan)
    {
        Gate::authorize('view', $perBulan);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-bulan.show', compact('perBulan', 'user', 'guru'));
    }

    // ================================
    // FORM EDIT / LENGKAPI
    // ================================
    public function edit(PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-bulan.edit', compact('perBulan', 'user', 'guru'));
    }


    // ================================
    // UPDATE / REVISI
    // ================================
    public function update(Request $request, PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        $request->validate([
            'daftar_gaji_path'   => 'nullable|mimes:pdf',
            'daftar_hadir_path'  => 'nullable|mimes:pdf',
            'rekening_bank_path' => 'nullable|mimes:pdf',
            'ceklist_berkas'     => 'nullable|mimes:pdf',
        ]);

        // CEK MINIMAL SATU FILE DIUPLOAD
        $hasFile =
            $request->hasFile('daftar_gaji_path') ||
            $request->hasFile('daftar_hadir_path') ||
            $request->hasFile('rekening_bank_path') ||
            $request->hasFile('ceklist_berkas');

        if (!$hasFile) {
            return back()
                ->withInput()
                ->with('error', 'Minimal unggah satu berkas untuk memperbarui.');
        }

        try {
            $data = $request->only([
                'daftar_gaji_path',
                'daftar_hadir_path',
                'rekening_bank_path',
                'ceklist_berkas',
                'catatan'
            ]);

            // pastikan hanya upload file yang valid
            foreach ($data as $key => $value) {
                if (!$request->hasFile($key)) {
                    unset($data[$key]); // jangan sampai string temp file ikut
                } else {
                    $data[$key] = $request->file($key);
                }
            }


            $this->service->update($data, $perBulan, Auth::user());

            // Refresh model so we read updated file paths saved by the service
            $perBulan->refresh();

            // CEK KELENGKAPAN BARU SETELAH UPDATE
            $fields = [
                $perBulan->daftar_gaji_path,
                $perBulan->daftar_hadir_path,
                $perBulan->rekening_bank_path,
                $perBulan->ceklist_berkas,
            ];

            $newStatus = in_array(null, $fields)
                ? 'belum lengkap'
                : 'menunggu';

            $perBulan->update([
                'status'  => $newStatus,
                'catatan' => null,
            ]);

            return redirect()->route('user.perbulan.index')
                ->with('success', 'Berkas berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('PerBulanUser update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berkas.');
        }
    }
}
