@extends('layouts.appadmin')

@section('title', 'Detail Data Periodik Persemester')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periodik
            Persemester</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periodik Persemester</h5>

            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control" value="{{ $perSemester->guru->user->name }}" readonly>
            </div>

            @php
                $fields = [
                    'sk_pbm_path' => 'SK PBM (File)',
                    'sk_terakhir_path' => 'SK Terakhir (File)',
                    'sk_berkala_path' => 'SK Berkala (File)',
                    'sp_bersedia_mengembalikan_path' => 'Surat Pernyataan Bersedia Mengembalikan (File)',
                    'sp_perangkat_pembelajaran_path' => 'Surat Pernyataan Perangkat Pembelajaran (File)',
                    'keaktifan_simpatika_path' => 'Keaktifan Simpatika (File)',
                    'berkas_s28a_path' => 'Berkas S28a (File)',
                    'berkas_skmt_path' => 'Berkas SKMT (File)',
                    'permohonan_skbk_path' => 'Permohonan SKBK (File)',
                    'berkas_skbk_path' => 'Berkas SKBK (File)',
                    'sertifikat_pengembangan_diri_path' => 'Sertifikat Pengembangan Diri (File)',
                ];
            @endphp

            @foreach ($fields as $name => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }}</label>
                    <input type="text" class="form-control mb-1"
                        value="{{ $perSemester->{$name} ? basename($perSemester->{$name}) : '-' }}" readonly>
                    @if ($perSemester->{$name})
                        <a href="{{ route('gdrive.preview', ['path' => $perSemester->{$name}]) }}" target="_blank"
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
                <input type="text" class="form-control text-capitalize" value="{{ $perSemester->status }}" readonly>
            </div>

            {{-- CATATAN --}}
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" value="{{ $perSemester->catatan ?? '-' }}" readonly>
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