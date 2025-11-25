@extends('layouts.appadmin')

@section('title', 'Edit Data Periodik Perbulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periodik
            Perbulan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Periodik Perbulan</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Periodik Perbulan</h5>

            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.per-bulan.update', $perBulan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Guru--}}
                <div id="guru_id">
                    <label for="guru_id" class="form-label">Guru</label>
                    <div class="mb-2 guru-group"
                        style="display: flex; flex-direction: row; justify-content: space-between;">
                        @php
                            $guruOptions = $gurus
                                ->mapWithKeys(fn($g) => [$g->id => $g->user->name ?? ($g->nip ?? 'Guru #' . $g->id)])
                                ->toArray();
                        @endphp
                        <x-select-input id="guru" name="guru_id" label="Guru" :options="$guruOptions" :selected="old('guru_id', $perBulan->guru_id)"
                            dropdownClass="flex-fill" />
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Daftar Gaji --}}
                <div class="mb-3">
                    <label for="daftar_gaji_path" class="form-label">Daftar Gaji (File)</label>

                    <!-- Input File -->
                    <input type="file" name="daftar_gaji_path" id="daftar_gaji_path" class="form-control" accept=".pdf">

                    <!-- Baris bawah: Lihat File + Nama File -->
                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        <a href="{{ route('gdrive.preview', ['path' => $perBulan->daftar_gaji_path]) }}" target="_blank"
                            class="text-primary text-decoration-underline">
                            Lihat File Lama
                        </a>
                        <span class="text-muted old-file-name">
                            {{ basename($perBulan->daftar_gaji_path) }}
                        </span>
                    </div>
                </div>


                {{-- Daftar Hadir --}}
                <div class="mb-3">
                    <label for="daftar_hadir_path" class="form-label">Daftar Hadir (File)</label>

                    <!-- Input File -->
                    <input type="file" name="daftar_hadir_path" id="daftar_hadir_path" class="form-control"
                        accept=".pdf">

                    <!-- Baris bawah: Lihat File + Nama File -->
                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        <a href="{{ route('gdrive.preview', ['path' => $perBulan->daftar_hadir_path]) }}" target="_blank"
                            class="text-primary text-decoration-underline">
                            Lihat File Lama
                        </a>
                        <span class="text-muted old-file-name">
                            {{ basename($perBulan->daftar_hadir_path) }}
                        </span>
                    </div>
                </div>


                {{-- Rekening Bank --}}
                <div class="mb-3">
                    <label for="rekening_bank_path" class="form-label">Rekening Bank (File)</label><br>

                    <!-- Input File -->
                    <input type="file" name="rekening_bank_path" id="rekening_bank_path" class="form-control"
                        accept=".pdf">

                    <!-- Baris bawah: Lihat File + Nama File -->
                    <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                        <a href="{{ route('gdrive.preview', ['path' => $perBulan->rekening_bank_path]) }}" target="_blank"
                            class="text-primary text-decoration-underline">
                            Lihat File Lama
                        </a>
                        <span class="text-muted old-file-name">
                            {{ basename($perBulan->rekening_bank_path) }}
                        </span>
                    </div>
                </div>

                {{-- Ceklist --}}
                <div class="mb-3">
                    <label for="ceklist_berkas" class="form-label">Ceklist Berkas</label>
                    <input type="text" name="ceklist_berkas" id="ceklist_berkas" class="form-control"
                        value="{{ old('ceklist_berkas', $perBulan->ceklist_berkas) }}" required>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="menunggu" {{ old('status', $perBulan->status) == 'menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>
                        <option value="diterima" {{ old('status', $perBulan->status) == 'diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>
                        <option value="ditolak" {{ old('status', $perBulan->status) == 'ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
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
                    /* default HP */
                    display: inline-block;
                }

                /* Tampilkan lebih panjang di tablet */
                @media (min-width: 576px) {
                    .old-file-name {
                        max-width: 250px;
                    }
                }

                /* Tampilkan full di laptop/desktop */
                @media (min-width: 992px) {
                    .old-file-name {
                        max-width: 100%;
                    }
                }
            </style>
        </div>
    </div>
    </div>
@endsection
