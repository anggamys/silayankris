@extends('layouts.appadmin')

@section('title', 'Edit Data Periode Per Bulan')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periode Per Bulan</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periode Per Bulan</li>
@endsection

@php
    $totalField = 4;
    $uploaded = collect([
        $perBulan->daftar_gaji_path,
        $perBulan->daftar_hadir_path,
        $perBulan->rekening_bank_path,
        $perBulan->ceklist_berkas,
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
        ][$perBulan->status] ?? 'badge bg-label-secondary';
@endphp

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periode Per Bulan</h5>
            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-bulan.update', $perBulan->id) }}" method="POST"
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
                            {{ $perBulan->status }}
                        </span>
                    </div>
                </div>

                {{-- Guru --}}
                <label class="form-label">Guru</label>
                <input type="text" class="form-control mb-2"
                    value="{{ $perBulan->guru->user->name ?? ($perBulan->guru->nip ?? 'Guru #' . $perBulan->guru->id) }}"
                    readonly>

                <input type="hidden" name="guru_id" value="{{ old('guru_id', $perBulan->guru_id) }}">

                {{-- Periode --}}
                <div class="mb-3">
                    <label for="periode_per_bulan" class="form-label">Periode (Bulan)</label>
                    <input type="month" id="periode_per_bulan" name="periode_per_bulan" class="form-control"
                        value="{{ old('periode_per_bulan', substr($perBulan->periode_per_bulan, 0, 7)) }}" required>
                </div>

                {{-- File Uploads --}}
                @foreach ([
            'daftar_gaji_path' => 'Daftar Gaji',
            'daftar_hadir_path' => 'Daftar Hadir',
            'rekening_bank_path' => 'Rekening Bank',
            'ceklist_berkas' => 'Ceklist Berkas',
        ] as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }} (File)</label>

                        <input type="file" id="{{ $field }}" name="{{ $field }}" class="form-control" accept=".pdf">

                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            @if ($perBulan->$field)
                                <a href="{{ route('gdrive.preview', ['path' => $perBulan->$field]) }}" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perBulan->$field) }}
                                </span>
                            @else
                                <span class="text-muted">Belum ada file</span>
                            @endif
                        </div>
                    </div>
                @endforeach


                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>

                    @if ($uploaded < 4)
                        <x-select-input id="status" name="status" :options="['belum lengkap' => 'Belum Lengkap']" :selected="$perBulan->status" :searchable="false"
                            disabled />

                        <small class="text-muted">
                            Status <strong>Belum Lengkap</strong>. Silakan lengkapi berkas terlebih dahulu dan <strong>Simpan</strong>.
                        </small>

                        <input type="hidden" name="status" value="belum lengkap">
                    @else
                        <x-select-input id="status" name="status" :options="[
                            'menunggu' => 'Menunggu',
                            'diterima' => 'Diterima',
                            'ditolak' => 'Ditolak',
                        ]" placeholder="Pilih Status"
                            :selected="old('status', $perBulan->status)" :searchable="false" required />
                    @endif
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="form-control"
                        value="{{ old('catatan', $perBulan->catatan) }}" placeholder="Masukkan catatan jika ada">
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
                document.getElementById('daftar_gaji_path'),
                document.getElementById('daftar_hadir_path'),
                document.getElementById('rekening_bank_path'),
                document.getElementById('ceklist_berkas'),
            ];

            const statusSelect = document.querySelector('[name="status"]');
            const statusPlaceholder = statusSelect.closest('.mb-3').querySelector('small');

            function checkFiles() {
                let filled = fileInputs.filter(i => i.files.length > 0).length;

                if (filled < 4) {
                    statusSelect.innerHTML = `<option value="belum lengkap">Belum Lengkap</option>`;
                    statusSelect.value = "belum lengkap";
                    statusSelect.setAttribute("disabled", true);
                    if (statusPlaceholder) {
                        statusPlaceholder.innerHTML =
                            "Status otomatis menjadi <strong>Belum Lengkap</strong> karena file belum lengkap.";
                    }
                } else {
                    statusSelect.removeAttribute("disabled");
                    statusSelect.innerHTML = `
                <option value="menunggu">Menunggu</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            `;
                    if (statusPlaceholder) statusPlaceholder.textContent = "";
                }
            }

            fileInputs.forEach(input => input.addEventListener('change', checkFiles));

        });
    </script>

@endsection
