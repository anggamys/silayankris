<?php

namespace App\Http\Controllers;

use App\Http\Requests\SekolahRequest;
use App\Models\Sekolah;
use App\Services\SekolahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SekolahController extends Controller
{
    protected $service;

    public function __construct(SekolahService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Sekolah::class);
        $search = $request->query('search');
        $sekolah = $this->service->getAll($search);

        $currentPage = $sekolah->currentPage();
        $lastPage = $sekolah->lastPage();
        $perPage = $sekolah->perPage();
        $total = $sekolah->total();

        return view('pages.admin.sekolah.index', compact(
            'currentPage',
            'lastPage',
            'perPage',
            'total',
            'sekolah',
            'search'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Sekolah::class);
        return view('pages.admin.sekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SekolahRequest $request)
    {
        Gate::authorize('create', Sekolah::class);
        $sekolah = $this->service->store($request->validated());
        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
