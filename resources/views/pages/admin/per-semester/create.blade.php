@extends('layouts.appadmin')

@section('title', 'Tambah Data Periode Per Semester')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periode
            Per Semester</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Periode Per-semester</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Periode Per-semester</h5>
            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-semester.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Guru --}}
                <div id="guru_id">
                    <label for="guru_id" class="form-label">Guru</label>
                    <div class="mb-2 guru-group"
                        style="display: flex; flex-direction: row; justify-content: space-between;">
                        @php
                            $guruOptions = $gurus
                                ->mapWithKeys(fn($g) => [$g->id => $g->user->name ?? ($g->nik ?? 'Guru #' . $g->id)])
                                ->toArray();
                        @endphp
                        <x-select-input id="guru" name="guru_id" label="Guru" :options="$guruOptions" :selected="old('guru_id')"
                            dropdownClass="flex-fill" required />
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Periode Per-semester --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Periode</label>
                    <input type="text" name="periode_per_semester" class="form-control"
                        placeholder="Contoh: Semester Genap 2024/2025" value="{{ old('periode_per_semester') }}" required>
                    <small class="text-muted d-block mt-1">Contoh: Semester Genap 2025/2026</small>

                    @error('periode_per_semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dokumen-dokumen Persemester (semua optional sesuai Request) --}}
                @php
                    $fields = [
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
                    ];
                @endphp

                @foreach ($fields as $name => $label)
                    <div class="mb-3">
                        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            accept=".pdf" placeholder="Pilih file PDF">
                        <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                        @error($name)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control"
                        placeholder="Masukkan catatan jika ada">
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
