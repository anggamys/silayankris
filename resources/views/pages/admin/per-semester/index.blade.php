@extends('layouts.appadmin')

@section('title', 'Manajemen Periode Persemester')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Periode Semester</li>
@endsection

@section('content')
    <x-toast />

    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            <h5 class="card-title fw-semibold">Daftar Data Periode Semester</h5>

            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100">
                        <div class="input-group w-100">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control border-end-1" placeholder="Cari...">
                            <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.per-semester.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Tabel --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-start">
                            <th>#</th>
                            <th>Nama Pengunggah</th>
                            <th>Tanggal Diunggah</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perSemester as $item)
                            <tr>
                                <td class="text-start">{{ $perSemester->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->guru->user->name }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $isIncomplete =
                                            !$item->sk_pbm_path ||
                                            !$item->sk_terakhir_path ||
                                            !$item->sk_berkala_path ||
                                            !$item->sp_bersedia_mengembalikan_path ||
                                            !$item->sp_perangkat_pembelajaran_path ||
                                            !$item->keaktifan_simpatika_path ||
                                            !$item->berkas_s28a_path ||
                                            !$item->berkas_skmt_path ||
                                            !$item->permohonan_skbk_path ||
                                            !$item->berkas_skbk_path ||
                                            !$item->sertifikat_pengembangan_diri_path;
                                    @endphp
                                    @if ($isIncomplete)
                                        <span class="badge bg-label-secondary">Belum Lengkap</span>
                                    @elseif($item->status == 'menunggu')
                                        <span class="badge bg-label-warning">Menunggu</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="badge bg-label-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-label-success">Diterima</span>
                                    @endif
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.per-semester.show', $item) }}"
                                        class="btn btn-sm btn-info text-light" data-bs-toggle="tooltip" title="Detail">
                                        <i class="bx bx-info-circle"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.per-semester.edit', $item) }}"
                                        class="btn btn-sm btn-warning text-light" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bx bx-pencil"></i> Ubah
                                    </a>
                                    <form action="{{ route('admin.per-semester.destroy', $item) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data periode persemester.
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
                    <strong>{{ $total }}</strong> data)
                </div>
                <div>
                    {{ $perSemester->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
