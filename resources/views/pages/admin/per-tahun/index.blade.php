@extends('layouts.appadmin')

@section('title', 'Manajemen Periode Per-tahun')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Periode Per-tahun</li>
@endsection

@section('content')
    <!-- Component Toast -->
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

        <div class="card-body ">
            {{-- Tabel Periode Per-tahun --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="text-start">
                            <th>No</th>
                            <th>Nama Pemilik</th>
                            <th>Periode</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Progress Upload</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perTahun as $item)
                            <tr>
                                @php
                                    // Cek kelengkapan file untuk progress bar
                                    $fields = [
                                        $item->biodata_path,
                                        $item->sertifikat_pendidik_path,
                                        $item->sk_dirjen_kelulusan_path,
                                        $item->nrg_path,
                                        $item->nuptk_path,
                                        $item->npwp_path,
                                        $item->ktp_path,
                                        $item->ijazah_sd_path,
                                        $item->ijazah_smp_path,
                                        $item->ijazah_sma_pga_path,
                                        $item->sk_pns_gty_path,
                                        $item->ijazah_s1_path,
                                        $item->transkrip_nilai_s1_path,
                                    ];
                                    $uploaded = collect($fields)->filter()->count();
                                    $filesTotal = 13;
                                    $progress = $filesTotal > 0 ? ($uploaded / $filesTotal) * 100 : 0;
                                @endphp
                                {{-- Make numbering continuous across pages using paginator firstItem() --}}
                                <td>{{ optional($perTahun)->firstItem() ? $perTahun->firstItem() + $loop->index : $loop->iteration }}
                                </td>

                                {{-- Nama --}}
                                <td>{{ $item->guru->user->name }}</td>

                                {{-- PERIODE --}}
                                <td>
                                    @if ($item->periode_per_tahun)
                                        {{ \Carbon\Carbon::parse($item->periode_per_tahun)->translatedFormat('Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- TANGGAL --}}
                                <td>{{ $item->created_at->format('d M Y') }}</td>

                                {{-- PROGRESS --}}
                                <td style="min-width: 60px;">
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar 
                            @if ($progress == 100) bg-success
                            @elseif($progress >= 50) bg-warning
                            @else bg-danger @endif"
                                            style="width: {{ $progress }}%;"></div>
                                    </div>
                                    <small class="text-muted">{{ $uploaded }}/{{ $filesTotal }}</small>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $isIncomplete =
                                            !$item->biodata_path ||
                                            !$item->sertifikat_pendidik_path ||
                                            !$item->sk_dirjen_kelulusan_path ||
                                            !$item->nrg_path ||
                                            !$item->nuptk_path ||
                                            !$item->npwp_path ||
                                            !$item->ktp_path ||
                                            !$item->ijazah_sd_path ||
                                            !$item->ijazah_smp_path ||
                                            !$item->ijazah_sma_pga_path ||
                                            !$item->sk_pns_gty_path ||
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

                                <!-- Aksi -->
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.per-tahun.show', $item) }}"
                                            class="btn btn-sm btn-info text-light">
                                            <i class="bx bx-info-circle"></i> Lihat
                                        </a>
                                        <a href="{{ route('admin.per-tahun.edit', $item) }}"
                                            class="btn btn-sm btn-warning text-light">
                                            <i class="bx bx-pencil"></i> Ubah
                                        </a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalCenter{{ $item->id }}">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>

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
                                                            Apakah anda yakin ingin menghapus <br>berkas milik
                                                            <strong>{{ Str::limit($item->guru->user->name, 25, '...') }}</strong>
                                                            ?
                                                        </p>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                Tidak
                                                            </button>
                                                            <form action="{{ route('admin.per-tahun.destroy', $item) }}"
                                                                method="POST">
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    Tidak ada data periode Per-tahun.
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
                    <strong>{{ $total }}</strong> periode Per-tahun)
                    <div>
                        {{ $perTahun->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
