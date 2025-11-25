<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GerejaRequest;
use App\Models\Gereja;
use App\Services\GerejaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class GerejaController extends Controller
{
    protected $service;
    public function __construct(GerejaService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Gereja::class);

        $search = $request->query('search');
        // $gere = $this->service->getAll($search);
        $gereja = $this->service->getAll($search);
        // return $gereja   ;
        $currentPage = $gereja->currentPage();
        $lastPage = $gereja->lastPage();
        $perPage = $gereja->perPage();
        $total = $gereja->total();

        return view('pages.admin.gereja.index', compact(
            'gereja',
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
        Gate::authorize('create', Gereja::class);
        return view('pages.admin.gereja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GerejaRequest $request)
    {
        Gate::authorize('create', Gereja::class);
        $data = $request->validated();
        $this->service->store($data);
        return redirect()->route('admin.gereja.index')->with('success', 'Gereja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gereja $gereja)
    {
        Gate::authorize('view', $gereja);
        return view('pages.admin.gereja.show', compact('gereja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gereja $gereja)
    {
        Gate::authorize('update', $gereja);

        return view('pages.admin.gereja.edit', compact('gereja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gereja $gereja): RedirectResponse
    {
        Gate::authorize('update', $gereja);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_berdiri' => 'nullable|date',
            'tanggal_bergabung_sinode' => 'nullable|date',
            'alamat' => 'required|string',
            'kab_kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kel_desa' => 'required|string',
            'jarak_gereja_lain' => 'nullable|string',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string|max:20',
            'nama_pendeta' => 'nullable|string|max:255',
            'status_gereja' => 'required|string',

            // JSON
            'jumlah_umat.laki_laki' => 'nullable|integer|min:0',
            'jumlah_umat.perempuan' => 'nullable|integer|min:0',

            'jumlah_majelis.laki_laki' => 'nullable|integer|min:0',
            'jumlah_majelis.perempuan' => 'nullable|integer|min:0',

            'jumlah_pemuda.laki_laki' => 'nullable|integer|min:0',
            'jumlah_pemuda.perempuan' => 'nullable|integer|min:0',

            'jumlah_guru_sekolah_minggu.laki_laki' => 'nullable|integer|min:0',
            'jumlah_guru_sekolah_minggu.perempuan' => 'nullable|integer|min:0',

            'jumlah_murid_sekolah_minggu.laki_laki' => 'nullable|integer|min:0',
            'jumlah_murid_sekolah_minggu.perempuan' => 'nullable|integer|min:0',
        ]);

        $this->service->update($gereja, $data);

        return redirect()
            ->route('admin.gereja.index')
            ->with('success', 'Gereja berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gereja $gereja): RedirectResponse
    {
        Gate::authorize('delete', $gereja);

        $this->service->delete($gereja);

        return redirect()
            ->route('admin.gereja.index')
            ->with('success', 'Gereja berhasil dihapus.');
    }
}
