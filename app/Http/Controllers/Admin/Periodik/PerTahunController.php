<?php

namespace App\Http\Controllers\Admin\Periodik;
use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerTahunRequest;
use App\Models\Guru;
use App\Models\PerTahun;
use App\Models\User;
use App\Services\Periodik\PerTahunService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerTahunController extends Controller
{

    protected $service;

    public function __construct(PerTahunService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', PerTahun::class);

        $search = $request->query('search');
        $perTahun = $this->service->getAll($search);

        $currentPage = $perTahun->currentPage();
        $lastPage = $perTahun->lastPage();
        $perPage = $perTahun->perPage();
        $total = $perTahun->total();

        return view('pages.admin.per-tahun.index', compact(
            'perTahun',
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
        Gate::authorize('create', PerTahun::class);

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        return view('pages.admin.per-tahun.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerTahunRequest $request)
    {
        Gate::authorize('create', PerTahun::class);

        $user = Auth::user();

        // Jika pengguna admin, set pemilik berkas sebagai user milik guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user; // pass the related User model to the service, fallback to current user
        }

        // Wajib upload minimal 1 file
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

        $data = $request->validated();

        // Masukkan UploadedFile ke data
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
            'transkrip_nilai_s1_path'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey);
            }
        }

        // Periode → YYYY-01-01, jika formatnya YYYY
        if (!empty($data['periode_per_tahun']) && strlen($data['periode_per_tahun']) === 4) {
            $data['periode_per_tahun'] .= '-01-01';
        }

        // ==============================
        // STATUS OTOMATIS
        // ==============================
        $uploadedCount = collect([
            $request->file('biodata_path'),
            $request->file('sertifikat_pendidik_path'),
            $request->file('sk_dirjen_kelulusan_path'),
            $request->file('nrg_path'),
            $request->file('nuptk_path'),
            $request->file('npwp_path'),
            $request->file('ktp_path'),
            $request->file('ijazah_sd_path'),
            $request->file('ijazah_smp_path'),
            $request->file('ijazah_sma_pga_path'),
            $request->file('sk_pns_gty_path'),
            $request->file('ijazah_s1_path'),
            $request->file('transkrip_nilai_s1_path'),
        ])->filter()->count();

        $data['status'] = $uploadedCount < 13
            ? 'belum lengkap'
            : 'diterima';

        // Simpan data
        $this->service->store($data, $user);

        return redirect()->route('admin.per-tahun.index')
            ->with('success', 'Data per tahun berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerTahun $perTahun)
    {
        Gate::authorize('view', $perTahun);

        $perTahun->load('guru.user');

        return view('pages.admin.per-tahun.show', compact('perTahun'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerTahun $perTahun)
    {
        Gate::authorize('update', $perTahun);

        $perTahun->load('guru.user');

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        // ============================================
        // CEK KELENGKAPAN FILE (0–13 file)
        // ============================================
        $uploaded = collect([
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
        ])->filter()->count();

        // Jika file belum lengkap → hanya boleh status "belum lengkap"
        // Jika file lengkap → semua opsi muncul
        $statusOptions = $uploaded < 13
            ? ['belum lengkap' => 'Belum Lengkap']
            : [
                'menunggu' => 'Menunggu',
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak',
                'belum lengkap' => 'Belum Lengkap',
            ];

        return view('pages.admin.per-tahun.edit', compact('perTahun', 'gurus', 'statusOptions'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PerTahunRequest $request, PerTahun $perTahun)
    {
        Gate::authorize('update', $perTahun);

        $user = Auth::user();

        // Jika admin, data akan dimiliki oleh user milik guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user;
        }

        // Ambil data validasi
        $data = $request->validated();

        // Masukkan UploadedFile ke data
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
            'transkrip_nilai_s1_path'] as $key) {
            if ($request->hasFile($key)) {

                // masukkan UploadedFile ke $data
                $data[$key] = $request->file($key);

            } else {

                // Jangan override file lama dengan null
                unset($data[$key]);
            }
        }


        // Update data & file
        $this->service->update($data, $perTahun, $user);

        // Refresh agar data terbaru terbaca (khususnya path file)
        $perTahun->refresh();

        // Hitung file yang sudah lengkap
        $uploaded = collect([
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
        ])->filter()->count();

        /*
        |--------------------------------------------------------------------------
        | LOGIKA STATUS OTOMATIS — FINAL
        |--------------------------------------------------------------------------
        |
        | 1. Jika file < 4 → status = "belum lengkap"
        | 2. Jika file lengkap dan admin belum memilih status (karena dropdown
        |    disable), maka status otomatis "diterima"
        | 3. Jika file lengkap dan admin memilih manual, gunakan status pilihan admin
        |
        */

        if ($uploaded < 13) {
            // File belum lengkap → fix
            $perTahun->status = 'belum lengkap';
        } else {
            // File lengkap → cek apakah admin pilih status atau tidak
            $requestedStatus = $request->status;

            // Jika request membawa "belum lengkap", itu berasal dari input hidden
            $isAutoHidden = ($requestedStatus === "belum lengkap");

            if ($isAutoHidden) {
                // Jika sebelumnya status belum pernah final → auto diterima
                if (!in_array($perTahun->status, ['diterima', 'ditolak', 'menunggu'])) {
                    $perTahun->status = 'diterima';
                }
            } else {
                // Admin memilih status secara manual
                $perTahun->status = $requestedStatus;
            }
        }

        $perTahun->save();

        return redirect()->route('admin.per-tahun.index')
            ->with('success', 'Data per tahun berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerTahun $perTahun)
    {
        Gate::authorize('delete', $perTahun);

        $this->service->destroy($perTahun);

        return redirect()->route('admin.per-tahun.index')
            ->with('success', 'Data per tahun berhasil dihapus');
    }
}