<?php

namespace App\Http\Controllers\User\Periodik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerSemesterRequest;
use App\Models\PerSemester;
use App\Services\Periodik\PerSemesterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PerSemesterUserController extends Controller
{
    protected $service;

    public function __construct(PerSemesterService $service)
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
        $items = $guru->perSemesters()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // Data untuk pagination info
        $currentPage = $items->currentPage();
        $lastPage    = $items->lastPage();
        $perPage     = $items->perPage();
        $total       = $items->total();

        return view('pages.user.per-semester.index', compact(
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
        return view('pages.user.per-semester.create');
    }

    // ================================
    // STORE DATA
    // ================================

    public function store(PerSemesterRequest $request)
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
            $request->hasFile('sk_pbm_path') ||
            $request->hasFile('sk_terakhir_berkala_path') ||
            $request->hasFile('sp_bersedia_mengembalikan_path') ||
            $request->hasFile('sp_kebenaran_berkas_path') ||
            $request->hasFile('sp_perangkat_pembelajaran_path') ||
            $request->hasFile('keaktifan_simpatika_path') ||
            $request->hasFile('berkas_s28a_path') ||
            $request->hasFile('berkas_skmt_path') ||
            $request->hasFile('permohonan_skbk_path') ||
            $request->hasFile('berkas_skbk_path') ||
            $request->hasFile('sertifikat_pengembangan_diri_path');

        if (!$hasFile) {
            return back()->withInput()->with('error', 'Anda harus mengupload minimal 1 berkas.');
        }

        try {
            // Set guru_id
            $validated['guru_id'] = $guru->id;

            // Tentukan status awal (lengkap / belum lengkap)
            $files = [
                $validated['sk_pbm_path'] ?? null,
                $validated['sk_terakhir_berkala_path'] ?? null,
                $validated['sp_bersedia_mengembalikan_path'] ?? null,
                $validated['sp_kebenaran_berkas_path'] ?? null,
                $validated['sp_perangkat_pembelajaran_path'] ?? null,
                $validated['keaktifan_simpatika_path'] ?? null,
                $validated['berkas_s28a_path'] ?? null,
                $validated['berkas_skmt_path'] ?? null,
                $validated['permohonan_skbk_path'] ?? null,
                $validated['berkas_skbk_path'] ?? null,
                $validated['sertifikat_pengembangan_diri_path'] ?? null,
            ];

            $validated['status'] = in_array(null, $files)
                ? 'belum lengkap'
                : 'menunggu';

            // Merge UploadedFile instances into validated data so the service
            // receives real UploadedFile objects instead of PHP temp names.
            foreach (['sk_pbm_path', 'sk_terakhir_path', 'sk_berkala_path', 'sp_bersedia_mengembalikan_path', 'sp_perangkat_pembelajaran_path', 'keaktifan_simpatika_path', 'berkas_s28a_path', 'berkas_skmt_path', 'permohonan_skbk_path', 'berkas_skbk_path', 'sertifikat_pengembangan_diri_path'] as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $validated[$fileKey] = $request->file($fileKey);
                }
            }

            $this->service->store($validated, $user);

            return redirect()->route('user.persemester.index')
                ->with('success', 'Berkas semester berhasil diunggah.');

        } catch (\Throwable $e) {
            Log::error('PerSemesterUser store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan.');
        }
    }


    // ================================
    // DETAIL
    // ================================
    public function show(PerSemester $perSemester)
    {
        Gate::authorize('view', $perSemester);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-semester.show', compact('perSemester', 'user', 'guru'));
    }

    // ================================
    // FORM EDIT / LENGKAPI
    // ================================
    public function edit(PerSemester $perSemester)
    {
        Gate::authorize('update', $perSemester);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-semester.edit', compact('perSemester', 'user', 'guru'));
    }


    // ================================
    // UPDATE / REVISI
    // ================================
    public function update(Request $request, PerSemester $perSemester)
    {
        Gate::authorize('update', $perSemester);

        $request->validate([
            'sk_pbm_path' => 'nullable|mimes:pdf',
            'sk_terakhir_berkala_path' => 'nullable|mimes:pdf',
            'sp_bersedia_mengembalikan_path' => 'nullable|mimes:pdf',
            'sp_kebenaran_berkas_path' => 'nullable|mimes:pdf',
            'sp_perangkat_pembelajaran_path' => 'nullable|mimes:pdf',
            'keaktifan_simpatika_path' => 'nullable|mimes:pdf',
            'berkas_s28a_path' => 'nullable|mimes:pdf',
            'berkas_skmt_path' => 'nullable|mimes:pdf',
            'permohonan_skbk_path' => 'nullable|mimes:pdf',
            'berkas_skbk_path' => 'nullable|mimes:pdf',
            'sertifikat_pengembangan_diri_path' => 'nullable|mimes:pdf',
        ]);

        // CEK MINIMAL SATU FILE DIUPLOAD
        $hasFile =
            $request->hasFile('sk_pbm_path') ||
            $request->hasFile('sk_terakhir_berkala_path') ||
            $request->hasFile('sp_bersedia_mengembalikan_path') ||
            $request->hasFile('sp_kebenaran_berkas_path') ||
            $request->hasFile('sp_perangkat_pembelajaran_path') ||
            $request->hasFile('keaktifan_simpatika_path') ||
            $request->hasFile('berkas_s28a_path') ||
            $request->hasFile('berkas_skmt_path') ||
            $request->hasFile('permohonan_skbk_path') ||
            $request->hasFile('berkas_skbk_path') ||
            $request->hasFile('sertifikat_pengembangan_diri_path');

        if (!$hasFile) {
            return back()
                ->withInput()
                ->with('error', 'Minimal unggah satu berkas untuk memperbarui.');
        }

        try {
            $data = $request->only([
                'sk_pbm_path',
                'sk_terakhir_berkala_path',
                'sp_bersedia_mengembalikan_path',
                'sp_kebenaran_berkas_path',
                'sp_perangkat_pembelajaran_path',
                'keaktifan_simpatika_path',
                'berkas_s28a_path',
                'berkas_skmt_path',
                'permohonan_skbk_path',
                'berkas_skbk_path',
                'sertifikat_pengembangan_diri_path',
            ]);

            // pastikan hanya upload file yang valid
            foreach ($data as $key => $value) {
                if (!($request->hasFile($key))) {
                    unset($data[$key]); // jangan sampai string temp file ikut
                } else {
                    $data[$key] = $request->file($key);
                }
            }

            $this->service->update($data, $perSemester, Auth::user());

            // Refresh model so we read updated file paths saved by the service
            $perSemester->refresh();

            // CEK KELENGKAPAN BARU SETELAH UPDATE
            $fields = [
                $perSemester->sk_pbm_path,
                $perSemester->sk_terakhir_berkala_path,
                $perSemester->sp_bersedia_mengembalikan_path,
                $perSemester->sp_kebenaran_berkas_path,
                $perSemester->sp_perangkat_pembelajaran_path,
                $perSemester->keaktifan_simpatika_path,
                $perSemester->berkas_s28a_path,
                $perSemester->berkas_skmt_path,
                $perSemester->permohonan_skbk_path,
                $perSemester->berkas_skbk_path,
                $perSemester->sertifikat_pengembangan_diri_path,
            ];

            $newStatus = in_array(null, $fields)
                ? 'belum lengkap'
                : 'menunggu';

            $perSemester->update([
                'status'  => $newStatus,
                'catatan' => null,
            ]);

            return redirect()->route('user.persemester.index')
                ->with('success', 'Berkas berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('PerSemesterUser update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berkas.');
        }
    }
}
