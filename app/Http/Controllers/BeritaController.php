<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeritaRequest;
use App\Models\Berita;
use App\Services\BeritaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BeritaController extends Controller
{
    protected $service;

    public function __construct(BeritaService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Berita::class);
        $search = $request->query('search');
        $berita = $this->service->getAll($search);
        $berita = $berita->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $currentPage = $berita->currentPage();
        $lastPage = $berita->lastPage();
        $perPage = $berita->perPage();
        $total = $berita->total();
        return view('pages.admin.berita.index', compact(
            'berita',
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
        Gate::authorize('create', Berita::class);
        return view('pages.admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BeritaRequest $request)
    {
        Gate::authorize('create', Berita::class);
      
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $this->service->store($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
{
    Gate::authorize('view', $berita);
    
    return view('pages.admin.berita.show', compact('berita'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
    Gate::authorize('update', $berita);
    return view('pages.admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BeritaRequest $request, Berita $berita)
    {
        Gate::authorize('update', $berita);
        $data = $request->validated();
        $this->service->update($berita, $data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        Gate::authorize('update', $berita);
        $this->service->delete($berita);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }



    public function publicIndex(Request $request)
    {
        $search = $request->query('search');
        $berita = $this->service->getAll($search);
        $randomBerita = Berita::inRandomOrder()->take(5)->get();
        $berita = $berita->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
        $currentPage = $berita->currentPage();
        $lastPage = $berita->lastPage();
        $perPage = $berita->perPage();
        $total = $berita->total();
         return view('pages.guest.berita.index', compact(
            'berita',
            'randomBerita',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total'
        ));
    }

    public function publicShow(Berita $berita)
    {   
        $beritaPopuler = $this->service->getAll();
        $beritaPopuler = $berita->orderBy('created_at', 'desc')->take(6)->get();
        $randomBerita = Berita::inRandomOrder()->take(5)->get();
        return view('pages.guest.berita.show', compact('berita', 'randomBerita', 'beritaPopuler'));
    }
}
