<?php

namespace App\Http\Controllers\Periodik;

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

        $gurus = Guru::all();

        return view('pages.admin.per-bulan.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerBulanRequest $request)
    {
        Gate::authorize('create', PerBulan::class);

        $user = Auth::user();

        // Jika pengguna admin, set pemilik berkas sebagai guru yang dipilih
        if ($user->role === User::ROLE_ADMIN) {
            $user = Guru::findOrFail($request['guru_id']);
        }

        $this->service->store($request->all(), $user);
        return redirect()->route('admin.per-bulan.index')->with('success', 'Data per bulan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerBulan $perBulan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerBulan $perBulan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerBulan $perBulan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerBulan $perBulan)
    {
        //
    }
}
