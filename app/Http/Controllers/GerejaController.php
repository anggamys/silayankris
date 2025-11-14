<?php

namespace App\Http\Controllers;

use App\Models\Gereja;
use App\Services\GerejaService;
use Illuminate\Http\Request;

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
            'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
