@extends('layouts.appadmin')

@section('title', 'Tambah Data Periode Per Bulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periode
            Per Bulan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Periode Per Bulan</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Periode Per Bulan</h5>

            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.per-bulan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Guru --}}
                <div id="guru_id">
                    <label for="guru_id" class="form-label">Guru</label>
                    <div class="mb-2 guru-group"
                        style="display: flex; flex-direction: row; justify-content: space-between;">
                        @php
                            $guruOptions = $gurus
                                ->mapWithKeys(fn($g) => [$g->id => $g->user->name ?? ($g->nip ?? 'Guru #' . $g->id)])
                                ->toArray();
                        @endphp
                        <x-select-input id="guru" name="guru_id" label="Guru" :options="$guruOptions" :selected="old('guru_id')"
                            dropdownClass="flex-fill" required />
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Periode --}}
                <div class="mb-3">
                    <label for="periode_per_bulan" class="form-label">Periode Per-Bulan</label>
                    <input type="month" name="periode_per_bulan" id="periode_per_bulan" class="form-control" required
                        min="{{ now()->subMonths(35)->format('Y-m') }}" max="{{ now()->format('Y-m') }}"
                        value="{{ old('periode_per_bulan') }}">
                    @error('periode_per_bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Daftar Gaji --}}
                <div class="mb-3">
                    <label for="daftar_gaji_path" class="form-label">Daftar Gaji (File)</label>
                    <input type="file" name="daftar_gaji_path" id="daftar_gaji_path" class="form-control" accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('daftar_gaji_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Daftar Hadir --}}
                <div class="mb-3">
                    <label for="daftar_hadir_path" class="form-label">Daftar Hadir (File)</label>
                    <input type="file" name="daftar_hadir_path" id="daftar_hadir_path" class="form-control"
                        accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('daftar_hadir_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rekening Bank --}}
                <div class="mb-3">
                    <label for="rekening_bank_path" class="form-label">Rekening Bank (File)</label>
                    <input type="file" name="rekening_bank_path" id="rekening_bank_path" class="form-control"
                        accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('rekening_bank_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ceklist Berkas --}}
                <div class="mb-3">
                    <label for="ceklist_berkas" class="form-label">Ceklist Berkas (File)</label>
                    <input type="file" name="ceklist_berkas" id="ceklist_berkas" class="form-control" accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('ceklist_berkas')
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

                <div class="d-flex
            justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
