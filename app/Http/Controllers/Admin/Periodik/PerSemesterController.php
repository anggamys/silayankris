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

        $gurus = Guru::all();

        return view('pages.admin.per-semester.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerSemesterRequest $request)
    {
        Gate::authorize('create', PerSemester::class);

        $user = Auth::user();

        // Jika pengguna admin, set pemilik berkas sebagai user milik guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $guru = Guru::findOrFail($request['guru_id']);
            $user = $guru->user ?? $user; // pass the related User model to the service, fallback to current user
        }

        $this->service->store($request->all(), $user);
        return redirect()->route('admin.per-semester.index')->with('success', 'Data per semester berhasil disimpan');
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

        $gurus = Guru::all();

        return view('pages.admin.per-semester.edit', compact('perSemester', 'gurus'));
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

        $this->service->update($request->all(), $perSemester, $user);

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