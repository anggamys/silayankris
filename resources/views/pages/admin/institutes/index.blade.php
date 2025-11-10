@extends('layouts.appadmin')

@section('title', 'Manajemen Institusi')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manajemen Institusi</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">

        <div class="card-header bg-white border-0 mb-2">
            {{-- Row responsive: di mobile col-12 (full), di md col-6 untuk search dan auto untuk button --}}
            <h5 class="card-title fw-semibold">Manajemen Institusi</h5>

            <div class="row g-2 align-items-center">

                <!-- Search: full width on mobile, half on md+ -->
                <div class="col-12 col-md-6">
                    <div class="input-group  w-100">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-end-1 "
                            placeholder="Cari institusi...">
                        <button class="btn btn-outline-secondary border" type="button">Cari</button>
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

            {{-- Tabel Institusi --}}
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
                                <td class="text-center">{{ $institutes->firstItem() + $loop->index }}</td>

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
                                        <i class="bx bx-info-circle"></i>
                                    </a>

                                    <a href="{{ route('admin.institutes.edit', $institute) }}"
                                        class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bx bx-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.institutes.destroy', $institute) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus institusi ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-building-x fs-4 d-block mb-2"></i>
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
