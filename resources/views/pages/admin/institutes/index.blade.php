@extends('layouts.appadmin')

@section('title', 'Manajemen Institusi')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manajemen Institusi</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Manajemen Institusi</h5>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center gap-2">
                {{-- Form Pencarian --}}
                <form method="get" class="row g-2 flex-grow-1">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-start-0" placeholder="Cari...">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">
                            Cari
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.institutes.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Tambah institusi
                </a>
            </div>


            {{-- Tabel User --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-nowrap rounded-3 overflow-hidden">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($institutes as $institute)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $institute->name }}</td>
                                <td>{{ $institute->category }}</td>
                                <td>{{ $institute->address }}</td>
                                <td>
                                    <span
                                        class="badge {{ $institute->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($institute->status) }}
                                    </span>
                                </td>
                                <td>{{ $institute->created_at->format('d-m-Y H:i') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.institutes.show', $institute) }}" class="btn btn-sm btn-info"
                                        data-bs-toggle="tooltip" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.institutes.edit', $institute) }}" class="btn btn-sm btn-warning"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.institutes.destroy', $institute) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus institusi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data institusi.
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
                    <strong>{{ $total }}</strong> institusi)
                </div>
                <div>
                    {{ $institutes->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
