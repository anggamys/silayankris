<?php

namespace App\Http\Controllers\Admin\Periodik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periodik\PerSemesterRequest;
use App\Models\Guru;
use App\Models\PerSemester;
use App\Models\User;
use App\Services\Periodik\PerSemesterService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerSemesterController extends Controller
{

    protected $service;

    public function __construct(PerSemesterService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', PerSemester::class);

        $search = $request->query('search');
        $perSemester = $this->service->getAll($search);

        $currentPage = $perSemester->currentPage();
        $lastPage = $perSemester->lastPage();
        $perPage = $perSemester->perPage();
        $total = $perSemester->total();

        return view('pages.admin.per-semester.index', compact(
            'perSemester',
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
        Gate::authorize('create', PerSemester::class);

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        return view('pages.admin.per-semester.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerSemesterRequest $request)
    {
        Gate::authorize('create', PerSemester::class);

        $user = Auth::user();

        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user; 
        }

        // Wajib upload minimal 1 file
        $hasFile =
            $request->hasFile('sk_pbm_path') ||
            $request->hasFile('sk_terakhir_path') ||
            $request->hasFile('sk_berkala_path') ||
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

        $data = $request->validated();

        // Masukkan UploadedFile ke data
        foreach (['sk_pbm_path','sk_terakhir_path','sk_berkala_path','sp_bersedia_mengembalikan_path','sp_perangkat_pembelajaran_path','keaktifan_simpatika_path','berkas_s28a_path','berkas_skmt_path','permohonan_skbk_path','berkas_skbk_path','sertifikat_pengembangan_diri_path'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey);
            }
        }

        // Periode -> Set semester (semester ganjil: 01 July - 31 Dec, semester genap: 01 Jan - 30 June)
        if (!empty($data['periode_per_semester']) && strlen($data['periode_per_semester']) === 7) {
            $month = (int) substr($data['periode_per_semester'], 5, 2);
            $year = (int) substr($data['periode_per_semester'], 0, 4);
            $data['semester'] = ($month >= 7) ? 'ganjil' : 'genap';
        }

        // ==============================
        // STATUS OTOMATIS
        // ==============================
        $uploadedCount = collect([
            $request->file('sk_pbm_path'),
            $request->file('sk_terakhir_path'),
            $request->file('sk_berkala_path'),
            $request->file('sp_bersedia_mengembalikan_path'),
            $request->file('sp_kebenaran_berkas_path'),
            $request->file('sp_perangkat_pembelajaran_path'),
            $request->file('keaktifan_simpatika_path'),
            $request->file('berkas_s28a_path'),
            $request->file('berkas_skmt_path'),
            $request->file('permohonan_skbk_path'),
            $request->file('berkas_skbk_path'),
            $request->file('sertifikat_pengembangan_diri_path'),
        ])->filter()->count();

        $data['status'] = $uploadedCount < 12
            ? 'belum lengkap'
            : 'diterima';

        // Simpan data
        $this->service->store($data, $user);    

        return redirect()->route('admin.per-semester.index')
            ->with('success', 'Data per semester berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerSemester $perSemester)
    {
        Gate::authorize('view', $perSemester);

        $perSemester->load('guru.user');

        return view('pages.admin.per-semester.show', compact('perSemester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerSemester $perSemester)
    {
        Gate::authorize('update', $perSemester);

        $perSemester->load('guru.user');

        // Only include gurus whose related user is active. Eager load user to avoid N+1.
        $gurus = Guru::with('user')
            ->whereHas('user', function  ($q) {
                $q->where('status', User::STATUS_AKTIF);
            })->get();

        // =====================================
        // CEK KELENGKAPAN FILE (0-12 file)
        // =====================================
        $uploaded = collect([
            $perSemester->sk_pbm_path,
            $perSemester->sk_terakhir_path,
            $perSemester->sk_berkala_path,
            $perSemester->sp_bersedia_mengembalikan_path,
            $perSemester->sp_kebenaran_berkas_path,
            $perSemester->sp_perangkat_pembelajaran_path,
            $perSemester->keaktifan_simpatika_path,
            $perSemester->berkas_s28a_path,
            $perSemester->berkas_skmt_path,
            $perSemester->permohonan_skbk_path,
            $perSemester->berkas_skbk_path,
            $perSemester->sertifikat_pengembangan_diri_path,
        ])->filter()->count();

        // Jika file belum lengkap -> hanya boleh status "belum lengkap"
        // Jika sudah lengkap -> boleh semua status
        $statusOptions = $uploaded < 12
            ? ['belum lengkap' => 'Belum Lengkap']
            : ['menunggu' => 'Menunggu', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak', 'belum lengkap' => 'Belum Lengkap'];

        return view('pages.admin.per-semester.edit', compact('perSemester', 'gurus', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerSemesterRequest $request, PerSemester $perSemester)
    {
        Gate::authorize('update', $perSemester);

        $user = Auth::user();

        // Jika admin, data akan dimiliki oleh user milik guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user; // pass the related User model to the service, fallback to current user
        }

        // Ambil data validasi
        $data = $request->validated();

        // Masukkan UploadedFile ke data
        foreach (['sk_pbm_path','sk_terakhir_path','sk_berkala_path','sp_bersedia_mengembalikan_path','sp_perangkat_pembelajaran_path','keaktifan_simpatika_path','berkas_s28a_path','berkas_skmt_path','permohonan_skbk_path','berkas_skbk_path','sertifikat_pengembangan_diri_path'] as $key) {
            if ($request->hasFile($key)) {

                // masukkan UploadedFile ke $data
                $data[$key] = $request->file($key);

            } else {

                // Jangan override file lama dengan null
                unset($data[$key]);
            }
        }


        // Update data & file
        $this->service->update($data, $perSemester, $user);

        // Refresh agar data terbaru terbaca (khususnya path file)
        $perSemester->refresh();

        // Hitung file yang sudah lengkap
        $uploaded = collect([
            $perSemester->sk_pbm_path,
            $perSemester->sk_terakhir_path,
            $perSemester->sk_berkala_path,
            $perSemester->sp_bersedia_mengembalikan_path,
            $perSemester->sp_kebenaran_berkas_path,
            $perSemester->sp_perangkat_pembelajaran_path,
            $perSemester->keaktifan_simpatika_path,
            $perSemester->berkas_s28a_path,
            $perSemester->berkas_skmt_path,
            $perSemester->permohonan_skbk_path,
            $perSemester->berkas_skbk_path,
            $perSemester->sertifikat_pengembangan_diri_path,
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

        if ($uploaded < 12) {
            // File belum lengkap → fix
            $perSemester->status = 'belum lengkap';
        } else {
            // File lengkap → cek apakah admin pilih status atau tidak
            $requestedStatus = $request->status;

            // Jika request membawa "belum lengkap", itu berasal dari input hidden
            $isAutoHidden = ($requestedStatus === "belum lengkap");

            if ($isAutoHidden) {
                // Jika sebelumnya status belum pernah final → auto diterima
                if (!in_array($perSemester->status, ['diterima', 'ditolak', 'menunggu'])) {
                    $perSemester->status = 'diterima';
                }
            } else {
                // Admin memilih status secara manual
                $perSemester->status = $requestedStatus;
            }
        }

        $perSemester->save();

        return redirect()->route('admin.per-semester.index')
            ->with('success', 'Data per semester berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerSemester $perSemester)
    {
        Gate::authorize('delete', $perSemester);

        $this->service->destroy($perSemester);

        return redirect()->route('admin.per-semester.index')
            ->with('success', 'Data per semester berhasil dihapus');
    }
}