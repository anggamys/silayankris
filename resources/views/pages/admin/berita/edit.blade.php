@extends('layouts.appadmin')

@section('title', 'Edit Berita')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.berita.index') }}" class="text-decoration-none">Manajemen Berita</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Edit Berita</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Edit Berita</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" 
                           value="{{ old('judul', $berita->judul) }}" required
                           placeholder="Masukkan judul berita">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Isi --}}
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita</label>
                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                              id="isi" name="isi" rows="6" required
                              placeholder="Tulis isi berita di sini...">{{ old('isi', $berita->isi) }}</textarea>
                    @error('isi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label for="gambar_path" class="form-label">Gambar Berita (OPSIONAL)</label>

                    {{-- Gambar saat ini --}}
                    <div class="mb-3">
                        <img id="current-image"
                             src="{{ $berita->gambar_path ? asset('storage/' . $berita->gambar_path) : asset('assets/images/no-image.png') }}" 
                             alt="Gambar Berita"
                             class="img-thumbnail"
                             style="max-height: 200px; object-fit: cover;">
                    </div>

                    {{-- Input file baru --}}
                    <input type="file" class="form-control @error('gambar_path') is-invalid @enderror" 
                           id="gambar_path" name="gambar_path" accept="image/*"
                           onchange="previewImage(event)">
                    @error('gambar_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script ubah gambar saat ini jika file baru dipilih --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('current-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Ganti gambar saat ini
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
