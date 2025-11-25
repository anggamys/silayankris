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

        $gurus = Guru::all();

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

        $this->service->store($request->all(), $user);
        return redirect()->route('admin.per-tahun.index')->with('success', 'Data per tahun berhasil disimpan');
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

        $gurus = Guru::all();

        return view('pages.admin.per-tahun.edit', compact('perTahun', 'gurus'));
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
            $user = $guru->user ?? $user; // pass the related User model to the service, fallback to current user
        }

        $this->service->update($request->all(), $perTahun, $user);

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