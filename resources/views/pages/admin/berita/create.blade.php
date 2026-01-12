@extends('layouts.appadmin')

@section('title', 'Tambah Berita')

@section('breadcrumb')
	<li class="breadcrumb-item">
		<a href="{{ route('admin.berita.index') }}" class="text-decoration-none">Data Berita</a>
	</li>
	<li class="breadcrumb-item active" aria-current="page">Tambah Berita</li>
@endsection

@section('content')
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Tambah Berita</h5>

			<a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Batal
			</a>
		</div>

		<div class="card-body">
			<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
				@csrf

				{{-- Judul --}}
				<div class="mb-3">
					<label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
					<input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
						value="{{ old('judul') }}" required placeholder="Masukkan judul berita">
					@error('judul')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- Isi --}}
				<div class="mb-3">
					<label for="isi" class="form-label">Isi Berita <span class="text-danger">*</span></label>
					<textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="6" required
					 placeholder="Tulis isi berita di sini...">{{ old('isi') }}</textarea>
					@error('isi')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				{{-- Preview gambar --}}
				<div class="mt-3 d-none" id="preview-container">
					<p class="mb-1 text-muted">Preview Gambar:</p>
					<img id="preview-image" src="#" alt="Preview Gambar" class="img-thumbnail"
						style="max-height: 200px; object-fit: cover;">
				</div>
				{{-- Gambar --}}
				<div class="mb-3">
					<label for="gambar_path" class="form-label">Gambar Berita (opsional)</label>
					<input type="file" class="form-control @error('gambar_path') is-invalid @enderror" id="gambar_path"
						name="gambar_path" accept="image/*" onchange="previewImage(event)">
					@error('gambar_path')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- Tombol --}}
				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-save me-1"></i> Simpan
					</button>
				</div>
			</form>
		</div>
	</div>

	{{-- Script preview gambar --}}
	<script>
		function previewImage(event) {
			const input = event.target;
			const container = document.getElementById('preview-container');
			const image = document.getElementById('preview-image');

			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					image.src = e.target.result;
					container.classList.remove('d-none');
				};
				reader.readAsDataURL(input.files[0]);
			} else {
				container.classList.add('d-none');
			}
		}
	</script>

@endsection
