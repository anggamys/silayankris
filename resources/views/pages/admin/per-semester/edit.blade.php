@extends('layouts.appadmin')

@section('title', 'Ubah Data Periode Per Semester')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periode
            Per Semester</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periode Per Semester</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periode Per Semester</h5>
            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-semester.update', $perSemester->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Guru --}}
                <div id="guru_id">
                    <label for="guru_id" class="form-label">Guru</label>
																				<input type="text" class="form-control mb-2"
																								value="{{ $perSemester->guru->user->name ?? ($perSemester->guru->nip ?? 'Guru #' . $perSemester->guru->id) }}"
																								readonly>

																				{{-- INPUT HIDDEN (DIKIRIM) --}}	
																				<input type="hidden" name="guru_id" value="{{ $perSemester->guru_id }}">

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
                        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @php $oldPath = $perSemester->{$name}; @endphp
                            @if ($oldPath)
                                <a href="{{ route('gdrive.preview', ['path' => $oldPath]) }}" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">{{ basename($oldPath) }}</span>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </div>

                        @error($name)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <x-select-input id="status" label="Status" name="status" :options="[
                        'menunggu' => 'Menunggu',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ]"
                        placeholder="Pilih Status" :selected="old('status', $perSemester->status)" :searchable="false" required />
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control"
                        value="{{ old('catatan', $perSemester->catatan) }}" placeholder="Masukkan catatan jika ada">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

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
        </div>
    </div>
@endsection
