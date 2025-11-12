@extends('layouts.appadmin')

@section('title', 'Manajemen Sekolah')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Sekolah</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">

        <div class="card-header bg-white border-0 mb-2">
            {{-- Row responsive: di mobile col-12 (full), di md col-6 untuk search dan auto untuk button --}}
            <h5 class="card-title fw-semibold">Daftar Data Sekolah</h5>

            <div class="row g-2 align-items-center">

                <!-- Search -->
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100">
                        <div class="input-group  w-100">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-end-1 " placeholder="Cari nama atau alamat...">
                            <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Button: full width on mobile, auto-width on md+ and aligned to right -->
                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body ">
            {{-- Tabel Sekolah --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="text-start">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sekolah as $item)
                            <tr>
                                <td class="text-start">{{ $sekolah->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->nama }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.sekolah.show', $item) }}"
                                        class="btn btn-sm btn-info align-items-center text-light" data-bs-toggle="tooltip"
                                        title="Detail">
                                        <i class="bx bx-info-circle"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.sekolah.edit', $item) }}"
                                        class="btn btn-sm btn-warning text-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bx bx-pencil"></i>
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.sekolah.destroy', $item) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus sekolah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger " data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data sekolah.
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
                    <strong>{{ $total }}</strong> sekolah)
                </div>
                <div>
                    {{ $sekolah->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
