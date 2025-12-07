@extends('layouts.appadmin')

@section('title', 'Detail Data Periode Per-bulan')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periode Per-bulan</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Periode Per-bulan</li>
@endsection

@php
    $totalField = 4;
    $uploaded = collect([
        $perBulan->daftar_gaji_path,
        $perBulan->daftar_hadir_path,
        $perBulan->rekening_bank_path,
        $perBulan->ceklist_berkas,
    ])
        ->filter()
        ->count();

    $progress = ($uploaded / $totalField) * 100;

    $statusBadgeClass =
        [
            'menunggu' => 'badge bg-label-warning',
            'ditolak' => 'badge bg-label-danger',
            'diterima' => 'badge bg-label-success',
            'belum lengkap' => 'badge bg-label-secondary',
        ][$perBulan->status] ?? 'badge bg-label-secondary';
@endphp

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periode Per-bulan
                <span class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2">
                    {{ \Carbon\Carbon::parse($perBulan->periode_per_bulan)->translatedFormat('(F Y)') }}
                </span>
            </h5>

            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- PROGRESS SECTION --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-semibold mb-0">Progress Pengajuan</h5>
                </div>

                <div class="card-body">

                    <label class="form-label fw-semibold">Kelengkapan Berkas</label>
                    <div class="progress mb-2" style="height: 18px;">
                        <div class="progress-bar 
                        @if ($progress == 100) bg-success
                        @elseif($progress >= 50) bg-warning text-dark
                        @else bg-danger @endif"
                            style="width: {{ $progress }}%;">
                            {{ round($progress) }}%
                        </div>
                    </div>

                    <small class="text-muted">
                        {{ $uploaded }} dari {{ $totalField }} dokumen terupload
                    </small>

                    <hr>

                    <label class="form-label fw-semibold">Status Pengajuan</label><br>
                    <span class="badge {{ $statusBadgeClass }} px-3 py-2 text-capitalize">
                        {{ $perBulan->status }}
                    </span>

                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perBulan->catatan ?? '-' }}</textarea>
                    </div>

                </div>
            </div>

            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control"
                    value="{{ $perBulan->guru->user->name ?? ($perBulan->guru->nip ?? 'Guru #' . $perBulan->guru->id) }}"
                    readonly>
            </div>

            {{-- PERIODE --}}
            <div class="mb-3">
                <label class="form-label">PERIODE (BULAN)</label>
                <input type="text" class="form-control"
                    value="{{ old('periode_per_bulan', \Carbon\Carbon::parse($perBulan->periode_per_bulan)->translatedFormat('F Y')) }}"
                    readonly>
            </div>

            {{-- FILE-FILE --}}
            @foreach ([
            'daftar_gaji_path' => 'Daftar Gaji',
            'daftar_hadir_path' => 'Daftar Hadir',
            'rekening_bank_path' => 'Rekening Bank',
            'ceklist_berkas' => 'Ceklist Berkas',
        ] as $field => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }} (File)</label>

                    <input type="text" class="form-control mb-2" value="{{ basename($perBulan->$field) }}" readonly>

                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        @if ($perBulan->$field)
                            <a href="{{ route('gdrive.preview', ['path' => $perBulan->$field]) }}" target="_blank"
                                class="text-primary text-decoration-underline">
                                Lihat File Lama
                            </a>
                        @else
                            <span class="text-muted">Belum ada file</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
