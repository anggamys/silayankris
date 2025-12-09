@extends('layouts.appadmin')

@section('title', 'Tambah Data Periode Per-tahun')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periode
            Per-tahun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Periode Per-tahun</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Periode Per-tahun</h5>
            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-tahun.store') }}" method="POST" enctype="multipart/form-data">
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

                {{-- Periode Per-tahun --}}
                <div class="mb-3">
                    <label for="periode_per_tahun" class="form-label">Periode Per-tahun</label>
                    <div class="mb-3">
                        <x-select-input label="Periode" name="periode_per_tahun" :options="collect(range(now()->subYears(10)->year, now()->year))
                            ->mapWithKeys(fn($year) => [$year => $year])
                            ->toArray()" required
                            placeholder="Pilih Periode" :value="old('periode_per_tahun')" />
                        @error('periode_per_tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Dokumen-dokumen Per-tahun (semua optional sesuai Request) --}}
                @php
                    $fields = [
                        'biodata_path' => 'Biodata (File)',
                        'sertifikat_pendidik_path' => 'Sertifikat Pendidik (File)',
                        'sk_dirjen_kelulusan_path' => 'Surat Keterangan Dirjen atau Kelulusan (File)',
                        'nrg_path' => 'NRG - Nomor Registrasi Guru (File)',
                        'nuptk_path' => 'NUPTK - Nomor Unik Pendidik dan Tenaga Kependidikan (File)',
                        'npwp_path' => 'NPWP - Nomor Pokok Wajib Pajak (File)',
                        'ktp_path' => 'KTP - Kartu Tanda Penduduk (File)',
                        'ijazah_sd_path' => 'Ijazah SD (File)',
                        'ijazah_smp_path' => 'Ijazah SMP (File)',
                        'ijazah_sma_pga_path' => 'Ijazah SMA atau PGA (File)',
                        'sk_pns_gty_path' => 'Surat Keterangan PNS atau GTY (File)',
                        'ijazah_s1_path' => 'Ijazah S1 (File)',
                        'transkrip_nilai_s1_path' => 'Transkrip Nilai S1 (File)',
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
