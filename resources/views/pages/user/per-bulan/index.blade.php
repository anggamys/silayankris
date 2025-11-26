@extends('layouts.app')

@section('title', 'Berkas Perbulan')

@section('content')
    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark fs-6 mb-0 text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="" class="text-dark fs-6 mb-0 text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <span class="text-dark fs-6 mb-0">Upload Berkas PerBulan</span>
        </div>
    </div>

    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Upload Berkas Perbulan</h1>
            <p class="text-light fs-6 mb-0">Layanan Guru untuk upload berkas perbulan</p>
        </div>
    </div>


    <div class="container py-5">
        {{-- RIWAYAT PENGAJUAN --}}
        <div class="text-center mb-4">
            <extralarge class="text-muted d-block fw-semibold">Per-bulan</extralarge>
            <h2 class="fw-bold mb-0">Riwayat Upload Berkas</h2>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    {{-- nama guru --}}
                                    <td>{{ $item->guru->user->name ?? 'Guru #' . $item->guru_id }}</td>

                                    {{-- tanggal upload --}}
                                    <td>{{ $item->created_at->format('d M Y - H:i') }}</td>

                                    {{-- periode bulan
                                    <td>
                                        {{ $item->bulan ? \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') : '-' }}
                                        {{ $item->tahun }}
                                    </td>
                                    --}}

                                    {{-- status --}}
                                    <td>
                                        @php
                                            $isIncomplete =
                                                !$item->daftar_gaji_path ||
                                                !$item->daftar_hadir_path ||
                                                !$item->rekening_bank_path;
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

                                    {{-- tombol buka --}}
                                    <td>
                                        <a href="{{ route('user.perbulan.show', $item) }}"
                                            class="btn btn-sm btn-primary px-3">
                                            Buka
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada pengajuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- FORM UPLOAD BERKAS --}}

        @php
            $usedMonths = $items->pluck('bulan')->toArray();
        @endphp

        <div class="text-center mb-4">
            <large class="text-muted d-block fw-semibold">Per-bulan</large>
            <h2 class="fw-bold mb-0">Form Upload Berkas</h2>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">

                <form action="{{ route('user.perbulan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- INFORMASI GURU --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Informasi Data Guru</h5>
                        </div>

                        <div class="card-body">

                            {{-- NAMA - NIP - NO HP --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" value="{{ $guru->nip }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control" value="{{ $user->nomor_telepon }}" readonly>
                                </div>
                            </div>

                            {{-- TEMPAT LAHIR - TANGGAL LAHIR --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" value="{{ $guru->tempat_lahir }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control"
                                        value="{{ $guru->tanggal_lahir ? $guru->tanggal_lahir->format('d F Y') : '-' }}"
                                        readonly>
                                </div>
                            </div>

                            {{-- ASAL SEKOLAH INDUK --}}
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah Induk</label>
                                @if ($user->guru && $user->guru->sekolah && $user->guru->sekolah->count())
                                    @foreach ($user->guru->sekolah as $sekolah)
                                        <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}"
                                            readonly>
                                    @endforeach
                                @else
                                    <input type="text" class="form-control" value="-" readonly>
                                @endif
                            </div>

                        </div>
                    </div>



                    {{-- PILIH PERIODE --}}
                    <div class="card shadow-sm border-0 mb-4">

                        {{-- 
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Pilih Periode Berkas</h5>
                        </div>
                        <div class="card-body"></div>
                            <!-- Periode (gabungan bulan+tahun) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Periode</label>
                                <!-- HTML5 month input returns value in format YYYY-MM -->
                                <input type="month" name="periode" class="form-control" required
                                    value="{{ old('periode', date('Y-m')) }}">
                                <small class="text-muted">Pilih bulan dan tahun untuk periode berkas Anda</small>
                            </div>

                            <!-- Pastikan guru_id terkirim ke request (untuk validasi/service) -->
                            <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                        </div>
                        --}}

                        {{-- UPLOAD BERKAS --}}
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-semibold mb-0">Upload Berkas</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Daftar Gaji (PDF)</label>
                                <input type="file" name="daftar_gaji_path" class="form-control" accept=".pdf" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Daftar Hadir (PDF)</label>
                                <input type="file" name="daftar_hadir_path" class="form-control" accept=".pdf" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rekening Bank (PDF)</label>
                                <input type="file" name="rekening_bank_path" class="form-control" accept=".pdf"
                                    required>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i> Kirim
                                </button>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    </div>

@endsection
