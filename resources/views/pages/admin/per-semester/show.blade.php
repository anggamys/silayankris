@extends('layouts.appadmin')

@section('title', 'Detail Data Periode Per-semester')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periode Per-semester</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Periode Per-semester </li>
@endsection

@php
    $totalField = 11;
    $uploaded = collect([
        $perSemester->sk_pbm_path,
        $perSemester->sk_terakhir_berkala_path,
        $perSemester->sp_bersedia_mengembalikan_path,
        $perSemester->sp_kebenaran_berkas_path,
        $perSemester->sp_perangkat_pembelajaran_path,
        $perSemester->keaktifan_simpatika_path,
        $perSemester->berkas_s28a_path,
        $perSemester->berkas_skmt_path,
        $perSemester->permohonan_skbk_path,
        $perSemester->berkas_skbk_path,
        $perSemester->sertifikat_pengembangan_diri_path,
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
        ][$perSemester->status] ?? 'badge bg-label-secondary';
@endphp

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periode Per-semester
                <span
                    class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2">
                    ({{ $perSemester->periode_per_semester }})
                </span></h5>

            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
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
                        {{ $perSemester->status }}
                    </span>

                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perSemester->catatan ?? '-' }}</textarea>
                    </div>

                </div>
            </div>

            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control"
                    value="{{ $perSemester->guru->user->name ?? ($perSemester->guru->nik ?? 'Guru #' . $perSemester->guru->id) }}"
                    readonly>
            </div>

            {{-- PERIODE --}}
            <div class="mb-3">
                <label class="form-label">PERIODE (SEMESTER)</label>
                <input type="text" class="form-control"
                    value="{{ old('periode_per_semester', $perSemester->periode_per_semester) }}" readonly>
            </div>

            {{-- FILE-FILE --}}
            @foreach ([
            'sk_pbm_path' => 'Surat Keputusan PBM',
            'sk_terakhir_berkala_path' => 'Surat Keputusan Terakhir atau Berkala',
            'sp_bersedia_mengembalikan_path' => 'Surat Pernyataan Bersedia Mengembalikan',
            'sp_kebenaran_berkas_path' => 'Surat Pernyataan Kebenaran Berkas',
            'sp_perangkat_pembelajaran_path' => 'Surat Pernyataan Perangkat Pembelajaran',
            'keaktifan_simpatika_path' => 'Bukti Keaktifan di Simpatika',
            'berkas_s28a_path' => 'Berkas S28a',
            'berkas_skmt_path' => 'Berkas SKMT',
            'permohonan_skbk_path' => 'Surat Permohonan SKBK',
            'berkas_skbk_path' => 'Berkas SKBK',
            'sertifikat_pengembangan_diri_path' => 'Sertifikat Pengembangan Diri',
        ] as $field => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }} (File)</label>

                    <input type="text" class="form-control mb-2" value="{{ basename($perSemester->$field) }}" readonly>

                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        @if ($perSemester->$field)
                            <a href="{{ route('gdrive.preview', ['path' => $perSemester->$field]) }}" target="_blank"
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
