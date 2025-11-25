@extends('layouts.appadmin')

@section('title', 'Ubah Data Periodik Pertahun')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periodik Pertahun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periodik Pertahun</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periodik Pertahun</h5>

            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-tahun.update', $perTahun->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Guru --}}
                <div class="mb-3">
                    <label for="guru_id" class="form-label">Guru</label>
                    <select name="guru_id" id="guru_id" class="form-select" required>
                        <option value="" disabled>Pilih Guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ $guru->id == old('guru_id', $perTahun->guru_id) ? 'selected' : '' }}>
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
                        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                        <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control" accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @php $oldPath = $perTahun->{$name}; @endphp
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
                        <option value="menunggu" {{ old('status', $perTahun->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ old('status', $perTahun->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ old('status', $perTahun->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" value="{{ old('catatan', $perTahun->catatan) }}" placeholder="Masukkan catatan jika ada">
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
