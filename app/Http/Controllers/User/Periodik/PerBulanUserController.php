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

    // RIWAYAT
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return back()->with('error', 'Anda belum terhubung sebagai guru.');
        }

        $items = $guru->perBulans()->latest()->get();

        return view('pages.user.per-bulan.index', compact('items', 'user', 'guru'));
    }

    // FORM UPLOAD
    public function create()
    {
        return view('pages.user.per-bulan.create');
    }

    // STORE DATA
    public function store(PerBulanRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->back()->with('error', 'Anda belum terhubung sebagai guru.');
        }

        try {
            // Ensure the record is associated with the current guru and default status
            $validated['guru_id'] = $guru->id;
            if (! isset($validated['status'])) {
                $validated['status'] = 'menunggu';
            }

            // If the form sends a combined `periode` (YYYY-MM), keep it but also
            // populate bulan/tahun for consistency with admin flow.
            if (! empty($validated['periode']) && is_string($validated['periode'])) {
                try {
                    [$tahun, $bulan] = explode('-', $validated['periode']);
                    $validated['bulan'] = (int) $bulan;
                    $validated['tahun'] = (int) $tahun;
                } catch (\Throwable $ex) {
                    // ignore parse errors; service/model can still handle `periode` column
                }
            }

            $this->service->store($validated, $user);

            return redirect()->route('user.perbulan.index')
                ->with('success', 'Berkas bulanan berhasil diunggah.');
        } catch (\Throwable $e) {
            Log::error('PerBulanUser store error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan. Silakan coba lagi.');
        }
    }

    // DETAIL
    public function show(PerBulan $perBulan)
    {
        Gate::authorize('view', $perBulan);

        return view('pages.user.per-bulan.show', compact('perBulan'));
    }

    // FORM EDIT
    public function edit(PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        return view('pages.user.per-bulan.edit', compact('perBulan'));
    }

    // UPDATE / REVISI
    public function update(Request $request, PerBulan $perBulan)
    {
        Gate::authorize('update', $perBulan);

        $request->validate([
            'daftar_gaji_path'   => 'nullable|mimes:pdf',
            'daftar_hadir_path'  => 'nullable|mimes:pdf',
            'rekening_bank_path' => 'nullable|mimes:pdf',
        ]);

        try {
            $this->service->update($request->all(), $perBulan, Auth::user());

            // Reset status setelah revisi
            $perBulan->update([
                'status'  => 'menunggu',
                'catatan' => null, 
            ]);

            return redirect()->route('user.perbulan.index')
                ->with('success', 'Berkas berhasil diperbarui. Menunggu pemeriksaan admin.');

        } catch (\Throwable $e) {
            Log::error('PerBulanUser update error: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berkas.');
        }
    }
}
