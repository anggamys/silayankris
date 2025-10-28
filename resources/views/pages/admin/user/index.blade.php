@extends('layouts.appadmin')

@section('title', 'Manajemen User')

@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
       
        <div class="card-header">
            {{-- Row responsive: di mobile col-12 (full), di md col-6 untuk search dan auto untuk button --}}
            <h5 class="card-title fw-semibold">Manajemen User</h5>

            <div class="row g-2 align-items-center">

                <!-- Search: full width on mobile, half on md+ -->
                <div class="col-12 col-md-6">
                    <div class="input-group w-100">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0"
                            placeholder="Cari nama atau email...">
                        <button class="btn btn-outline-secondary" type="button">Cari</button>
                    </div>
                </div>

                <!-- Button: full width on mobile, auto-width on md+ and aligned to right -->
                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah User
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Tabel User --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-stripped table-hover">
                    <thead class="table-light">
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
                                <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'user' ? 'bg-primary' : 'bg-secondary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info align-items-center"
                                        data-bs-toggle="tooltip" title="Detail">
                                        <i class="bx bx-info-circle"></i>
                                        {{-- Lihat --}}
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="bx bx-pencil"></i>
                                        {{-- Ubah --}}
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                            {{-- Hapus --}}
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
