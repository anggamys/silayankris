@extends('layouts.appadmin')

@section('title', 'Ubah Data Periodik Persemester')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periodik Persemester</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periodik Persemester</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periodik Persemester</h5>
            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-semester.update', $perSemester->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Guru --}}
                <div class="mb-3">
                    <label for="guru_id" class="form-label">Guru</label>
                    <select name="guru_id" id="guru_id" class="form-select" required>
                        <option value="" disabled>Pilih Guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ $guru->id == old('guru_id', $perSemester->guru_id) ? 'selected' : '' }}>
                                {{ $guru->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control" accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @php $oldPath = $perSemester->{$name}; @endphp
                            @if ($oldPath)
                                <a href="{{ route('gdrive.preview', ['path' => $oldPath]) }}" target="_blank" class="text-primary text-decoration-underline">
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
                    <select name="status" id="status" class="form-select" required>
                        <option value="menunggu" {{ old('status', $perSemester->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ old('status', $perSemester->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ old('status', $perSemester->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" value="{{ old('catatan', $perSemester->catatan) }}" placeholder="Masukkan catatan jika ada">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

            <style>
                .old-file-name{
                    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
                    max-width:150px; display:inline-block;
                }
                @media (min-width:576px){ .old-file-name{ max-width:250px; } }
                @media (min-width:992px){ .old-file-name{ max-width:100%; } }
            </style>
        </div>
    </div>
@endsection
