@extends('layouts.appadmin')

@section('title', 'Detail Data Periode Per Tahun')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periode
            Per Tahun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periode Per Tahun</h5>

            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control" value="{{ $perTahun->guru->user->name }}" readonly>
            </div>

            @php
                $fields = [
                    'biodata_path' => 'Biodata (File)',
                    'sertifikat_pendidik_path' => 'Sertifikat Pendidik (File)',
                    'sk_dirjen_path' => 'SK Dirjen (File)',
                    'sk_kelulusan_path' => 'SK Kelulusan (File)',
                    'nrg_path' => 'NRG (File)',
                    'nuptk_path' => 'NUPTK (File)',
                    'npwp_path' => 'NPWP (File)',
                    'ktp_path' => 'KTP (File)',
                    'ijazah_sd_path' => 'Ijazah SD (File)',
                    'ijazah_smp_path' => 'Ijazah SMP (File)',
                    'ijazah_sma_path' => 'Ijazah SMA (File)',
                    'sk_pns_path' => 'SK PNS (File)',
                    'sk_gty_path' => 'SK GTY (File)',
                    'ijazah_s1_path' => 'Ijazah S1 (File)',
                    'transkrip_nilai_s1_path' => 'Transkrip Nilai S1 (File)',
                ];
            @endphp

            @foreach ($fields as $name => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }}</label>
                    <input type="text" class="form-control mb-1"
                        value="{{ $perTahun->{$name} ? basename($perTahun->{$name}) : '-' }}" readonly>
                    @if ($perTahun->{$name})
                        <a href="{{ route('gdrive.preview', ['path' => $perTahun->{$name}]) }}" target="_blank"
                            class="text-primary text-decoration-underline">
                            Lihat File
                        </a>
                    @else
                        <p class="text-muted">Belum ada file</p>
                    @endif
                </div>
            @endforeach

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control text-capitalize" value="{{ $perTahun->status }}" readonly>
            </div>

            {{-- CATATAN --}}
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" value="{{ $perTahun->catatan ?? '-' }}" readonly>
            </div>
        </div>
    </div>

    <style>
        .old-file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            display: inline-block;
        }

        @media (min-width:576px) {
            .old-file-name {
                max-width: 250px;
            }
        }

        @media (min-width:992px) {
            .old-file-name {
                max-width: 100%;
            }
        }
    </style>
@endsection