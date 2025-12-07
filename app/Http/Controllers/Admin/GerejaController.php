<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GerejaRequest;
use App\Models\Gereja;
use App\Services\GerejaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function update(GerejaRequest $request, Gereja $gereja): RedirectResponse
    {
        Gate::authorize('update', $gereja);
        $data = $request->validated();
        $this->service->update($gereja, $data);
        return redirect()->route('admin.gereja.index')->with('success', 'Gereja berhasil diperbarui!');
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

     public function indexUser()
    {
        $userId = Auth::id();
        $gereja = $this->service->getGerejaByUserId($userId);
        return view('pages.user.gereja.index', compact('gereja'));
    }

    public function updateUser(GerejaRequest $request, Gereja $gereja): RedirectResponse
    {
        $userId = Auth::id();
        
        // Pastikan user hanya bisa update gereja mereka sendiri
        $userGereja = $this->service->getGerejaByUserId($userId);
        
        if (!$userGereja || $userGereja->id !== $gereja->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        $this->service->update($gereja, $data);
        
        return redirect()->route('user.gereja.index')->with('success', 'Data gereja berhasil diperbarui!');
    }
}
