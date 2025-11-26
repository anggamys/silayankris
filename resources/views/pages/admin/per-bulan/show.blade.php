@extends('layouts.appadmin')

@section('title', 'Detail Data Periode Per Bulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periode
            Per Bulan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Periode Per Bulan</h5>

            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- GURU --}}
            <div class="mb-3">
                <label class="form-label">Guru</label>
                <input type="text" class="form-control" value="{{ $perBulan->guru->user->name }}" readonly>
            </div>

            {{-- DAFTAR GAJI --}}
            <div class="mb-3">
                <label class="form-label">Daftar Gaji (File)</label>

                <input type="text" class="form-control mb-1" value="{{ basename($perBulan->daftar_gaji_path) }}"
                    readonly>

                @if ($perBulan->daftar_gaji_path)
                    <a href="{{ route('gdrive.preview', ['path' => $perBulan->daftar_gaji_path]) }}" target="_blank"
                        class="text-primary text-decoration-underline">
                        Lihat File
                    </a>
                @else
                    <p class="text-muted">Belum ada file</p>
                @endif
            </div>

            {{-- DAFTAR HADIR --}}
            <div class="mb-3">
                <label class="form-label">Daftar Hadir (File)</label>

                <input type="text" class="form-control mb-1" value="{{ basename($perBulan->daftar_hadir_path) }}"
                    readonly>

                @if ($perBulan->daftar_hadir_path)
                    <a href="{{ route('gdrive.preview', ['path' => $perBulan->daftar_hadir_path]) }}" target="_blank"
                        class="text-primary text-decoration-underline">
                        Lihat File
                    </a>
                @else
                    <p class="text-muted">Belum ada file</p>
                @endif
            </div>

            {{-- REKENING BANK --}}
            <div class="mb-3">
                <label class="form-label">Rekening Bank (File)</label>

                <input type="text" class="form-control mb-1" value="{{ basename($perBulan->rekening_bank_path) }}"
                    readonly>

                @if ($perBulan->rekening_bank_path)
                    <a href="{{ route('gdrive.preview', ['path' => $perBulan->rekening_bank_path]) }}" target="_blank"
                        class="text-primary text-decoration-underline">
                        Lihat File
                    </a>
                @else
                    <p class="text-muted">Belum ada file</p>
                @endif
            </div>

            {{-- CEKLIST --}}
            <div class="mb-3">
                <label class="form-label">Ceklist Berkas</label>
                <input type="text" class="form-control" value="{{ $perBulan->ceklist_berkas }}" readonly>
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control text-capitalize" value="{{ $perBulan->status }}" readonly>
            </div>

            {{-- CATATAN --}}
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" value="{{ $perBulan->catatan ?? '-' }}" readonly>
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

        @media (min-width: 576px) {
            .old-file-name {
                max-width: 250px;
            }
        }

        @media (min-width: 992px) {
            .old-file-name {
                max-width: 100%;
            }
        }
    </style>

@endsection
