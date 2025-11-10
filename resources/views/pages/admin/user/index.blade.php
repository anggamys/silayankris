@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        {{-- Card Header --}}
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold" style="color: #1b3a2f;">Manajemen User</h5>
        </div>

        <div class="card-body">
            {{-- Search & Add Button --}}
            <div class="d-flex justify-content-between mb-3 align-items-center gap-2 flex-wrap">
                <form method="get" class="row g-2 flex-grow-1">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-success"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-start-0" placeholder="Cari nama atau email...">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Tambah User
                </a>
            </div>

            {{-- Tabel User --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-nowrap rounded-3 overflow-hidden">
                    <thead class="table-success text-success">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'user' ? 'bg-success' : 'bg-secondary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-success"
                                        data-bs-toggle="tooltip" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="small text-muted">
                    Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
                    Menampilkan <strong>{{ $perPage }}</strong> data per halaman (total
                    <strong>{{ $total }}</strong> user)
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
