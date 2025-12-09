@extends('layouts.appadmin')

@section('title', 'Edit Data Periode Per-tahun')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-tahun.index') }}" class="text-decoration-none">Data Periode Per-tahun</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periode Per-tahun</li>
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
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periode Per-tahun <span
                    class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2 text-muted">
                    {{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('(Y)') }}
                </span></h5>
            <a href="{{ route('admin.per-tahun.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-tahun.update', $perTahun->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Progress Section --}}
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

                {{-- Guru --}}
                <label class="form-label">Guru</label>
                <input type="text" class="form-control mb-2"
                    value="{{ $perTahun->guru->user->name ?? ($perTahun->guru->nik ?? 'Guru #' . $perTahun->guru->id) }}"
                    readonly>

                <input type="hidden" name="guru_id" value="{{ old('guru_id', $perTahun->guru_id) }}">

                {{-- Periode --}}
                <div class="mb-3">
                    <label for="periode_per_tahun" class="form-label">Periode (Tahun)</label>
                    <input type="text" name="periode_per_tahun" id="periode_per_tahun"
                        class="form-control @error('periode_per_tahun') is-invalid @enderror"
                        value="{{ \Carbon\Carbon::parse($perTahun->periode_per_tahun)->translatedFormat('Y') }}" readonly>
                </div>

                {{-- File Uploads --}}
                @foreach ([
            'biodata_path' => 'Biodata',
            'sertifikat_pendidik_path' => 'Sertifikat Pendidik',
            'sk_dirjen_kelulusan_path' => 'Surat Keterangan Dirjen atau Kelulusan',
            'nrg_path' => 'NRG - Nomor Registrasi Guru',
            'nuptk_path' => 'NUPTK - Nomor Unik Pendidik dan Tenaga Kependidikan',
            'npwp_path' => 'NPWP - Nomor Pokok Wajib Pajak',
            'ktp_path' => 'KTP - Kartu Tanda Penduduk',
            'ijazah_sd_path' => 'Ijazah SD',
            'ijazah_smp_path' => 'Ijazah SMP',
            'ijazah_sma_pga_path' => 'Ijazah SMA atau PGA',
            'sk_pns_gty_path' => 'Surat Keterangan PNS atau GTY',
            'ijazah_s1_path' => 'Ijazah S1',
            'transkrip_nilai_s1_path' => 'Transkrip Nilai S1',
        ] as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }} (File)</label>

                        <input type="file" id="{{ $field }}" name="{{ $field }}" class="form-control"
                            accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @if ($perTahun->$field)
                                <a href="{{ route('gdrive.preview', ['path' => $perTahun->$field]) }}" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perTahun->$field) }}
                                </span>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </div>
                    </div>
                @endforeach


                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>

                    @if ($uploaded < 11)
                        {{-- Kalau file di DATABASE belum lengkap, status disable --}}
                        <x-select-input id="status" name="status" :options="['belum lengkap' => 'Belum Lengkap']" :selected="$perTahun->status" :searchable="false"
                            disabled />

                        <input type="hidden" name="status" value="belum lengkap">

                        <small class="text-muted">
                            Lengkapi seluruh file lalu klik <strong>Simpan</strong> untuk bisa mengubah status.
                        </small>
                    @else
                        {{-- Jika FILE di DB sudah lengkap, barulah admin boleh ubah status --}}
                        <x-select-input id="status" name="status" :options="[
                            'menunggu' => 'Menunggu',
                            'diterima' => 'Diterima',
                            'ditolak' => 'Ditolak',
                        ]" :selected="old('status', $perTahun->status)"
                            placeholder="Pilih Status" :searchable="false" required />
                    @endif
                </div>


                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control"
                        value="{{ old('catatan', $perTahun->catatan) }}" placeholder="Masukkan catatan jika ada">
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const fileInputs = [
                document.getElementById('biodata_path'),
                document.getElementById('sertifikat_pendidik_path'),
                document.getElementById('sk_dirjen_kelulusan_path'),
                document.getElementById('nrg_path'),
                document.getElementById('nuptk_path'),
                document.getElementById('npwp_path'),
                document.getElementById('ktp_path'),
                document.getElementById('ijazah_sd_path'),
                document.getElementById('ijazah_smp_path'),
                document.getElementById('ijazah_sma_pga_path'),
                document.getElementById('sk_pns_gty_path'),
                document.getElementById('ijazah_s1_path'),
                document.getElementById('transkrip_nilai_s1_path'),
            ];

            // The custom select component uses a hidden input with name="status" and
            // a visible button with id="btn-status". We must not treat the hidden
            // input as a <select>. Instead, update its value and enable/disable the
            // visible button so the hidden input is still submitted.
            const hiddenStatusInput = document.querySelector('[name="status"]');
            const statusButton = document.getElementById('btn-status');
            const statusWrapper = hiddenStatusInput ? hiddenStatusInput.closest('.mb-3') : null;
            const statusPlaceholder = statusWrapper ? statusWrapper.querySelector('small') : null;

        });
    </script>

@endsection
