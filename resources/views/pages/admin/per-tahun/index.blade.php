@extends('layouts.appadmin')

@section('title', 'Manajemen Periode Tahunan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Periode Tahunan</li>
@endsection

@section('content')
    <x-toast />

    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            <h5 class="card-title fw-semibold">Daftar Data Periode Per-tahun</h5>

            <div class="row g-2 align-items-center">

                <!-- Search -->
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100 d-flex align-items-center gap-2">
                        {{-- 🔍 Input pencarian --}}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                                placeholder="Cari...">
                            <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                        </div>

                        <a href="{{ url()->current() }}"
                            class="btn btn-secondary border d-flex align-items-center gap-1
          {{ request('search') ? '' : 'd-none' }}">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Reset</span>
                        </a>
                    </form>
                </div>

                <!-- Button tambah -->
                <div class="col-12 col-md-auto ms-md-auto text-md-end">
                    <a href="{{ route('admin.per-tahun.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pengunggah</th>
                            <th>Tanggal Diunggah</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perTahun as $item)
                            <tr>
                                <td>{{ $perTahun->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->guru->user->name }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $isIncomplete =
                                            !$item->biodata_path ||
                                            !$item->sertifikat_pendidik_path ||
                                            !$item->sk_dirjen_path ||
                                            !$item->sk_kelulusan_path ||
                                            !$item->nrg_path ||
                                            !$item->nuptk_path ||
                                            !$item->npwp_path ||
                                            !$item->ktp_path ||
                                            !$item->ijazah_sd_path ||
                                            !$item->ijazah_smp_path ||
                                            !$item->ijazah_sma_path ||
                                            !$item->sk_pns_path ||
                                            !$item->sk_gty_path ||
                                            !$item->ijazah_s1_path ||
                                            !$item->transkrip_nilai_s1_path;

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
                                    <a href="{{ route('admin.per-tahun.show', $item) }}"
                                        class="btn btn-sm btn-info text-light">
                                        <i class="bx bx-info-circle"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.per-tahun.edit', $item) }}"
                                        class="btn btn-sm btn-warning text-light">
                                        <i class="bx bx-pencil"></i> Ubah
                                    </a>
                                    <form action="{{ route('admin.per-tahun.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data ini?')">
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
                                    Tidak ada data periode tahunan.
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
                    {{ $perTahun->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
