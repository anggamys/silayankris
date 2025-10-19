<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstituteRequest;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Services\InstituteService;

class InstituteController extends Controller
{
    protected $service;

    public function __construct(InstituteService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource, with search.
     */
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', User::class);
        $search = $request->query('search');
        $institutes = $this->service->getAll($search);

        $currentPage = $institutes->currentPage();
        $lastPage = $institutes->lastPage();
        $perPage = $institutes->perPage();
        $total = $institutes->total();

        return view('pages.admin.institutes.index', compact(
            'institutes',
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
        // Gate::authorize('create', Institute::class);
        return view('pages.admin.institutes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstituteRequest $request)
    {
        // Gate::authorize('create', Institute::class);
        $institute = $this->service->store($request->validated());
        return redirect()->route('admin.institutes.index')->with('success', 'Institute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institute $institute)
    {
        // Gate::authorize('view', $institute);
        return view('pages.admin.institutes.show', compact('institute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institute $institute)
    {
        // Gate::authorize('update', $institute);
        return view('pages.admin.institutes.edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstituteRequest $request, Institute $institute)
    {
        // Gate::authorize('update', $institute);
        $this->service->update($institute, $request->validated());
        return redirect()->route('admin.institutes.index', $institute)->with('success', 'Institute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        // Gate::authorize('delete', $institute);
        $this->service->delete($institute);
        return redirect()->route('admin.institutes.index')->with('success', 'Institute deleted successfully.');
    }
}
