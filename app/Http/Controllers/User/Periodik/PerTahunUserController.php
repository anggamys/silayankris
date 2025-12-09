<?php

namespace App\Http\Controllers\User\Periodik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerTahunRequest;
use App\Models\PerTahun;
use App\Services\Periodik\PerTahunService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PerTahunUserController extends Controller
{
    protected $service;

    public function __construct(PerTahunService $service)
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
        $items = $guru->perTahuns()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        // Data untuk pagination info
        $currentPage = $items->currentPage();
        $lastPage    = $items->lastPage();
        $perPage     = $items->perPage();
        $total       = $items->total();

        return view('pages.user.per-tahun.index', compact(
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
        return view('pages.user.per-tahun.create');
    }

    // ================================
    // STORE DATA
    // ================================

    public function store(PerTahunRequest $request)
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
            $request->hasFile('biodata_path') ||
            $request->hasFile('sertifikat_pendidik_path') ||
            $request->hasFile('sk_dirjen_kelulusan_path') ||
            $request->hasFile('nrg_path') ||
            $request->hasFile('nuptk_path') ||
            $request->hasFile('npwp_path') ||
            $request->hasFile('ktp_path') ||
            $request->hasFile('ijazah_sd_path') ||
            $request->hasFile('ijazah_smp_path') ||
            $request->hasFile('ijazah_sma_pga_path') ||
            $request->hasFile('sk_pns_gty_path') ||
            $request->hasFile('ijazah_s1_path') ||
            $request->hasFile('transkrip_nilai_s1_path');

        if (!$hasFile) {
            return back()->withInput()->with('error', 'Anda harus mengupload minimal 1 berkas.');
        }

        try {
            // Set guru_id
            $validated['guru_id'] = $guru->id;

            // Tentukan status awal (lengkap / belum lengkap)
            $files = [
                $validated['biodata_path'] ?? null,
                $validated['sertifikat_pendidik_path'] ?? null,
                $validated['sk_dirjen_kelulusan_path'] ?? null,
                $validated['nrg_path'] ?? null,
                $validated['nuptk_path'] ?? null,
                $validated['npwp_path'] ?? null,
                $validated['ktp_path'] ?? null,
                $validated['ijazah_sd_path'] ?? null,
                $validated['ijazah_smp_path'] ?? null,
                $validated['ijazah_sma_pga_path'] ?? null,
                $validated['sk_pns_gty_path'] ?? null,
                $validated['ijazah_s1_path'] ?? null,
                $validated['transkrip_nilai_s1_path'] ?? null,
            ];

            $validated['status'] = in_array(null, $files)
                ? 'belum lengkap'
                : 'menunggu';

            // Merge UploadedFile instances into validated data so the service
            // receives real UploadedFile objects instead of PHP temp names.
            foreach ([
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
            'transkrip_nilai_s1_path'
            ] as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $validated[$fileKey] = $request->file($fileKey);
                }
            }

            $this->service->store($validated, $user);

            return redirect()->route('user.pertahun.index')
                ->with('success', 'Berkas tahunan berhasil diunggah.');

        } catch (\Throwable $e) {
            Log::error('PerTahunUser store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan.');
        }
    }


    // ================================
    // DETAIL
    // ================================
    public function show(PerTahun $perTahun)
    {
        Gate::authorize('view', $perTahun);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-tahun.show', compact('perTahun', 'user', 'guru'));
    }

    // ================================
    // FORM EDIT / LENGKAPI
    // ================================
    public function edit(PerTahun $perTahun)
    {
        Gate::authorize('update', $perTahun);

        $user = Auth::user();
        $guru = $user->guru;

        return view('pages.user.per-tahun.edit', compact('perTahun', 'user', 'guru'));
    }


    // ================================
    // UPDATE / REVISI
    // ================================
    public function update(Request $request, PerTahun $perTahun)
    {
        Gate::authorize('update', $perTahun);

        $request->validate([
         'biodata_path'              => 'nullable|mimes:pdf',
         'sertifikat_pendidik_path'  => 'nullable|mimes:pdf',
         'sk_dirjen_kelulusan_path'  => 'nullable|mimes:pdf',
         'nrg_path'                  => 'nullable|mimes:pdf',
         'nuptk_path'                => 'nullable|mimes:pdf',
         'npwp_path'                 => 'nullable|mimes:pdf',
         'ktp_path'                  => 'nullable|mimes:pdf',
         'ijazah_sd_path'            => 'nullable|mimes:pdf',
         'ijazah_smp_path'           => 'nullable|mimes:pdf',
         'ijazah_sma_pga_path'       => 'nullable|mimes:pdf',
         'sk_pns_gty_path'           => 'nullable|mimes:pdf',
         'ijazah_s1_path'            => 'nullable|mimes:pdf',
         'transkrip_nilai_s1_path'   => 'nullable|mimes:pdf'
        ]);

        // CEK MINIMAL SATU FILE DIUPLOAD
        $hasFile =
            $request->hasFile('biodata_path') ||
            $request->hasFile('sertifikat_pendidik_path') ||
            $request->hasFile('sk_dirjen_kelulusan_path') ||
            $request->hasFile('nrg_path') ||
            $request->hasFile('nuptk_path') ||
            $request->hasFile('npwp_path') ||
            $request->hasFile('ktp_path') ||
            $request->hasFile('ijazah_sd_path') ||
            $request->hasFile('ijazah_smp_path') ||
            $request->hasFile('ijazah_sma_pga_path') ||
            $request->hasFile('sk_pns_gty_path') ||
            $request->hasFile('ijazah_s1_path') ||
            $request->hasFile('transkrip_nilai_s1_path');
        if (!$hasFile) {
            return back()
                ->withInput()
                ->with('error', 'Minimal unggah satu berkas untuk memperbarui.');
        }

        try {
            $data = $request->only([
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


            $this->service->update($data, $perTahun, Auth::user());

            // Refresh model so we read updated file paths saved by the service
            $perTahun->refresh();

            // CEK KELENGKAPAN BARU SETELAH UPDATE
            $fields = [
                $perTahun->biodata_path,
                $perTahun->sertifikat_pendidik_path,
                $perTahun->sk_dirjen_kelulusan_path,
                $perTahun->nrg_path,
                $perTahun->nuptk_path,
                $perTahun->npwp_path,
                $perTahun->ktp_path,
                $perTahun->ijazah_sd_path,
                $perTahun->ijazah_smp_path,
                $perTahun->ijazah_sma_pga_path,
                $perTahun->sk_pns_gty_path,
                $perTahun->ijazah_s1_path,
                $perTahun->transkrip_nilai_s1_path,
            ];

            $newStatus = in_array(null, $fields)
                ? 'belum lengkap'
                : 'menunggu';

            $perTahun->update([
                'status'  => $newStatus,
                'catatan' => null,
            ]);

            return redirect()->route('user.pertahun.index')
                ->with('success', 'Berkas berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('PerTahunUser update error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berkas.');
        }
    }
}
