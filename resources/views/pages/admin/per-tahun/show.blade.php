@extends('layouts.appadmin')

@section('title', 'Detail Data Periode Per-tahun')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periode Per-tahun</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Periode Per-tahun </li>
@endsection

@php
    $totalField = 13;
    $uploaded = collect([
        $perTahun->biodata_path,
        $perTahun->sertifikat_pendidik_path,
        $perTahun->sk_dirjen_kelulusan_path,
        $perTahun->nrg_path,
        $perTahun->nuptk_path,
        $perTahun->npwp_path,
        $perTahun->ktp_path,
        $perTahun->ijazah_sd_path,
        $perTahun->ijazah_smp_path,
        $perTahun->ijazah_sma_pga_path,
        $perTahun->sk_pns_gty_path,
        $perTahun->ijazah_s1_path,
        $perTahun->transkrip_nilai_s1_path,
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
        ][$perTahun->status] ?? 'badge bg-label-secondary';
@endphp

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periode Per-tahun
                <span class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2 text-muted">
                    {{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('(Y)') }}
                </span>
            </h5>

            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
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
                        {{ $perTahun->status }}
                    </span>

                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perTahun->catatan ?? '-' }}</textarea>
                    </div>

                </div>
            </div>

            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control"
                    value="{{ $perTahun->guru->user->name ?? ($perTahun->guru->nip ?? 'Guru #' . $perTahun->guru->id) }}"
                    readonly>
            </div>

            {{-- PERIODE --}}
            <div class="mb-3">
                <label for="periode_per_tahun" class="form-label">Periode (Tahun)</label>
                <input type="text" name="periode_per_tahun" id="periode_per_tahun"
                    class="form-control @error('periode_per_tahun') is-invalid @enderror"
                    value="{{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('Y') }}" readonly>
            </div>

            {{-- FILE-FILE --}}
            @foreach ([
            'Biodata' => 'biodata_path',
            'Sertifikat Pendidik' => 'sertifikat_pendidik_path',
            'Surat Keterangan Dirjen atau Kelulusan' => 'sk_dirjen_kelulusan_path',
            'NRG - Nomor Registrasi Guru' => 'nrg_path',
            'NUPTK - Nomor Unik Pendidik dan Tenaga Kependidikan' => 'nuptk_path',
            'NPWP - Nomor Pokok Wajib Pajak' => 'npwp_path',
            'KTP - Kartu Tanda Penduduk' => 'ktp_path',
            'Ijazah SD' => 'ijazah_sd_path',
            'Ijazah SMP' => 'ijazah_smp_path',
            'Ijazah SMA atau PGA' => 'ijazah_sma_pga_path',
            'Surat Keterangan PNS atau GTY' => 'sk_pns_gty_path',
            'Ijazah S1' => 'ijazah_s1_path',
            'Transkrip Nilai S1' => 'transkrip_nilai_s1_path',
        ] as $field => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }} (File)</label>

                    <input type="text" class="form-control mb-2" value="{{ basename($perTahun->$field) }}" readonly>

                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        @if ($perTahun->$field)
                            <a href="{{ route('gdrive.preview', ['path' => $perTahun->$field]) }}" target="_blank"
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
