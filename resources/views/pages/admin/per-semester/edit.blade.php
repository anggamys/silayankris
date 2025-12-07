@extends('layouts.appadmin')

@section('title', 'Edit Data Periode Per-semester')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-semester.index') }}" class="text-decoration-none">Data Periode Per-semester</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periode Per-semester</li>
@endsection

@php
    $totalField = 11;
    $uploaded = collect([
        $perSemester->sk_pbm_path,
        $perSemester->sk_terakhir_berkala_path,
        $perSemester->sp_bersedia_mengembalikan_path,
        $perSemester->sp_kebenaran_berkas_path,
        $perSemester->sp_perangkat_pembelajaran_path,
        $perSemester->keaktifan_simpatika_path,
        $perSemester->berkas_s28a_path,
        $perSemester->berkas_skmt_path,
        $perSemester->permohonan_skbk_path,
        $perSemester->berkas_skbk_path,
        $perSemester->sertifikat_pengembangan_diri_path,
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
        ][$perSemester->status] ?? 'badge bg-label-secondary';
@endphp

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periode Per-semester <span
                    class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2">
                    ({{ $perSemester->periode_per_semester }})
                </span></h5>
            <a href="{{ route('admin.per-semester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-semester.update', $perSemester->id) }}" method="POST"
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
                            {{ $perSemester->status }}
                        </span>

                        <div class="mt-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea class="form-control" rows="3" readonly>{{ $perSemester->catatan ?? '-' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Guru --}}
                <label class="form-label">Guru</label>
                <input type="text" class="form-control mb-2"
                    value="{{ $perSemester->guru->user->name ?? ($perSemester->guru->nip ?? 'Guru #' . $perSemester->guru->id) }}"
                    readonly>

                <input type="hidden" name="guru_id" value="{{ old('guru_id', $perSemester->guru_id) }}">

                {{-- Periode --}}
                <div class="mb-3">
                    <label for="periode_per_semester" class="form-label">Periode (Semester)</label>
                    <input type="text" name="periode_per_semester" id="periode_per_semester"
                        class="form-control @error('periode_per_semester') is-invalid @enderror"
                        value="{{ old('periode_per_semester', $perSemester->periode_per_semester) }}" readonly>
                </div>

                {{-- File Uploads --}}
                @foreach ([
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
        ] as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }} (File)</label>

                        <input type="file" id="{{ $field }}" name="{{ $field }}" class="form-control"
                            accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @if ($perSemester->$field)
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->$field]) }}" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->$field) }}
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
                        <x-select-input id="status" name="status" :options="['belum lengkap' => 'Belum Lengkap']" :selected="$perSemester->status" :searchable="false"
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
                        ]" :selected="old('status', $perSemester->status)"
                            placeholder="Pilih Status" :searchable="false" required />
                    @endif
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
                document.getElementById('sk_pbm_path'),
                document.getElementById('sk_terakhir_berkala_path'),
                document.getElementById('sp_bersedia_mengembalikan_path'),
                document.getElementById('sp_kebenaran_berkas_path'),
                document.getElementById('sp_perangkat_pembelajaran_path'),
                document.getElementById('keaktifan_simpatika_path'),
                document.getElementById('berkas_s28a_path'),
                document.getElementById('berkas_skmt_path'),
                document.getElementById('permohonan_skbk_path'),
                document.getElementById('berkas_skbk_path'),
                document.getElementById('sertifikat_pengembangan_diri_path'),
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
