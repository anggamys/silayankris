@extends('layouts.appadmin')

@section('title', 'Tambah Data Periodik Pertahun')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periodik
            Pertahun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Periodik Pertahun</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Periodik Pertahun</h5>

            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.per-tahun.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Guru --}}
                <div class="mb-3">
                    <label for="guru_id" class="form-label">Guru</label>
                    <select name="guru_id" id="guru_id" class="form-select" required>
                        @if ($gurus->isEmpty())
                            <option value="" disabled>Tidak ada data guru tersedia</option>
                        @else
                            <option value="" disabled selected>Pilih Guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
                            @endforeach
                        @endif
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
                        <hint class="form-text">Format file harus .pdf</hint>
                        @error($name)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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