@extends('layouts.appadmin')

@section('title', 'Tambah Data Periodik Perbulan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.per-bulan.index') }}" class="text-decoration-none">Data Periodik
            Perbulan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Periodik Perbulan</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Periodik Perbulan</h5>

            <a href="{{ route('admin.per-bulan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.per-bulan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- select option guru --}}
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

                {{-- Daftar Gaji --}}
                <div class="mb-3">
                    <label for="daftar_gaji_path" class="form-label">Daftar Gaji (File)</label>
                    <input type="file" name="daftar_gaji_path" id="daftar_gaji_path" class="form-control" required
                        accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('daftar_gaji_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Daftar Hadir --}}
                <div class="mb-3">
                    <label for="daftar_hadir_path" class="form-label">Daftar Hadir (File)</label>
                    <input type="file" name="daftar_hadir_path" id="daftar_hadir_path" class="form-control" required
                        accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('daftar_hadir_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rekening Bank --}}
                <div class="mb-3">
                    <label for="rekening_bank_path" class="form-label">Rekening Bank (File)</label>
                    <input type="file" name="rekening_bank_path" id="rekening_bank_path" class="form-control" required
                        accept=".pdf">
                    <hint class="form-text">Format file harus .pdf</hint>
                    @error('rekening_bank_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ceklist_berkas" class="form-label">Ceklist Berkas</label>
                    <input type="text" name="ceklist_berkas" id="ceklist_berkas" class="form-control" required>
                    @error('ceklist_berkas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
