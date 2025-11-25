<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Gereja;
use App\Models\Sekolah;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource, with search.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);
        $search = $request->query('search');
        $users = $this->service->getAll($search);

        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $perPage = $users->perPage();
        $total = $users->total();

        return view('pages.admin.user.index', compact(
            'users',
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
    public function create(User $user)
    {
        Gate::authorize('create', User::class);

        $sekolahs = Sekolah::pluck('nama', 'id')
            ->toArray();
        $gerejas = Gereja::pluck('nama', 'id')
            ->toArray();

        return view('pages.admin.user.create', compact('sekolahs', 'gerejas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('create', User::class);
        $user = $this->service->store($request->validated());
        return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        $user->load(['guru.sekolah', 'staffGereja']);

        $sekolahs = Sekolah::pluck('nama', 'id')
            ->toArray();
        $gerejas = Gereja::pluck('nama', 'id')
            ->toArray();

        return view('pages.admin.user.show', compact('user', 'sekolahs', 'gerejas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $user->load(['guru.sekolah', 'staffGereja']);

        $sekolahs = Sekolah::pluck('nama', 'id')
            ->toArray();
        $gerejas = Gereja::pluck('nama', 'id')
            ->toArray();

        return view('pages.admin.user.edit', compact('user', 'sekolahs', 'gerejas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('update', $user);
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index', $user)->with('success', ' Data Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil dihapus.');
    }
}
