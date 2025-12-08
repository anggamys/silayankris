@extends('layouts.appadmin')

@section('title', 'Manajemen Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Gereja</li>
@endsection

@section('content')


    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 mb-2">
            
            <h5 class="card-title fw-semibold">Daftar Data Gereja</h5>

            <div class="row g-2 align-items-center">
                <!-- Search -->
                <div class="col-12 col-md-6">
                    <form method="GET" class="w-100 d-flex align-items-center gap-2">
                        {{-- 🔍 Input pencarian --}}
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                                placeholder="Cari judul berita...">
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
                    <a href="{{ route('admin.gereja.create') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Tabel Gereja --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="">
                        <tr class="text-start">
                            <th>#</th>
                            <th>Nama Gereja</th>
                            <th>Pengurus</th>
                            <th>Alamat</th>
                            <th>Tanggal Berdiri</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gereja as $item)
                            <tr>
                                <td>{{ $gereja->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $item->nama }}</td>
                                <td>
                                    {{ Str::limit($item->staffGereja->user->name ?? '-', 25, '...') }}
                                </td>


                                <td>{{ Str::limit($item->alamat ?? '-', 40, '...') }}</td>
                                <td>
                                    {{ $item->tanggal_berdiri
                                        ? \Carbon\Carbon::parse($item->tanggal_berdiri)->locale('id')->translatedFormat('d F Y')
                                        : '-' }}
                                </td>

                                <!-- Aksi -->
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.gereja.show', $item) }}"
                                        class="btn btn-sm btn-info text-light">
                                        <i class="bx bx-info-circle"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.gereja.edit', $item) }}"
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
                                                        Apakah anda yakin ingin menghapus
                                                        <strong>{{ Str::limit($item->nama, 15, '...') }}</strong> ?
                                                    </p>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Tidak
                                                        </button>
                                                        <form action="{{ route('admin.gereja.destroy', $item) }}"
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
                                    <i class="bi bi-file-earmark-x fs-4 d-block mb-2"></i>
                                    Tidak ada data gereja.
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
                    <strong>{{ $total }}</strong> gereja)
                </div>

                <div>
                    {{ $gereja->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
