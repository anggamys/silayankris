@extends('layouts.appadmin')

@section('title', 'Manajemen Berita')

@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen Berita</li>
@endsection

@section('content')

    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                   {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="card-title fw-semibold">Manajemen Berita</h5>

            <div class="row g-2 align-items-center">

                <!-- Search -->
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100">
                        <div class="input-group w-100">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>

                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-end-1" placeholder="Cari judul berita...">

                            <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Button tambah -->
                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Berita
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Tabel Berita --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-start">
                            <th>#</th>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th class="text-center">Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($berita as $item)
                            <tr>
                                <td>{{ $berita->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->judul }}</td>
                                <td>{{ $item->isi }}</td>

                                <td class="text-center">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>

                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.berita.show', $item) }}"
                                        class="btn btn-sm btn-info text-light">
                                        <i class="bx bx-info-circle"></i> Lihat
                                    </a>

                                    <a href="{{ route('admin.berita.edit', $item) }}"
                                        class="btn btn-sm btn-warning text-light">
                                        <i class="bx bx-pencil"></i> Ubah
                                    </a>

                                    <form action="{{ route('admin.berita.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-file-earmark-x fs-4 d-block mb-2"></i>
                                    Tidak ada data berita.
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
                    Menampilkan <strong>{{ $perPage }}</strong> per halaman (total
                    <strong>{{ $total }}</strong> berita)
                </div>

                <div>
                    {{ $berita->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
