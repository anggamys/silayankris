@extends('layouts.appadmin')

@section('title', 'Manajemen Periode Bulanan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Periode Bulanan</li>
@endsection

@section('content')
    <!-- Component Toast -->
    <x-toast />

    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            <h5 class="card-title fw-semibold">Daftar Data Periode Bulanan</h5>

            <div class="row g-2 align-items-center">

                <div class="col-12 col-md-6">
                    <div class="input-group  w-100">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-end-1 "
                            placeholder="Cari...">
                        <button class="btn btn-outline-secondary border" type="button">Cari</button>
                    </div>
                </div>

                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.per-bulan.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body ">
            {{-- Tabel Periode Bulanan --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="text-start">
                            <th>#</th>
                            <th>Nama Pengunggah</th>
                            <th>Tanggal Diunggah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perBulan as $item)
                            <tr>
                                <td class="text-start">{{ $perBulan->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->guru->user->name }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.per-bulan.show', $item) }}"
                                        class="btn btn-sm btn-info align-items-center text-light" data-bs-toggle="tooltip"
                                        title="Detail">
                                        <i class="bx bx-info-circle"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.per-bulan.edit', $item) }}"
                                        class="btn btn-sm btn-warning text-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bx bx-pencil"></i>
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.per-bulan.destroy', $item) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger " data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bx bx-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalCenter{{ $item->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalCenterTitle">Konfirmasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Apakah anda yakin ingin menghapus
                                                        <strong>{{ Str::limit($item->nama, 15, '...') }}</strong> ?
                                                    </p>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Tidak
                                                        </button>
                                                        <form action="{{ route('admin.sekolah.destroy', $item) }}"
                                                            method="POST" onsubmit=" ">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">
                                                                <i class="bx bx-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data periode bulanan.
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
                    {{ $perBulan->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
