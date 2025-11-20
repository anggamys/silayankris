@extends('layouts.appadmin')

@section('title', 'Detail Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Detail Data Pengguna</li>
@endsection

@section('content')
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Detail Data Pengguna</h5>
			<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Kembali
			</a>
		</div>
		<div class="card-body">
			{{-- FOTO PROFIL --}}
			<div class="text-center mb-3">
				@php
					$photoFile = null;
					if ($user->profile_photo_path) {
					    $dir = pathinfo($user->profile_photo_path, PATHINFO_DIRNAME);
					    $filename = pathinfo($user->profile_photo_path, PATHINFO_FILENAME);
					    $photoFile = $dir !== '.' ? $dir . '/' . $filename . '.jpg' : $filename . '.jpg';
					}
					$photoPath = $photoFile ? public_path('storage/' . $photoFile) : null;
				@endphp
				@if ($photoFile && $photoPath && file_exists($photoPath))
					<img src="{{ asset('storage/' . $photoFile) }}" class="img-thumbnail rounded"
						style="max-width: 180px; border: 2px solid #dee2e6;" alt="Foto Profil">
				@else
					<img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" class="img-thumbnail rounded"
						style="max-width: 180px; border: 2px solid #dee2e6;">
				@endif
			</div>

			<div class="row mb-3">
				<div class="col-md-6">
					<label class="form-label">Peran</label>
					<input type="text" class="form-control" value="{{ ucfirst(str_replace('-', ' ', $user->role)) }}" readonly>
				</div>
				<div class="col-md-6">
					<label class="form-label">Status</label>
					<input type="text" class="form-control" value="{{ ucfirst($user->status ?? 'Aktif') }}" readonly>
				</div>
			</div>

			<div class="mb-3">
				<label class="form-label">Nama</label>
				<input type="text" class="form-control" value="{{ $user->name }}" readonly>
			</div>
			<div class="mb-3">
				<label class="form-label">Email</label>
				<input type="email" class="form-control" value="{{ $user->email }}" readonly>
			</div>
			<div class="mb-3">
				<label class="form-label">Nomor Telepon</label>
				<input type="text" class="form-control" value="{{ $user->nomor_telepon }}" readonly>
			</div>

			{{-- FORM GURU --}}
			@if ($user->role === 'guru' && $user->guru)
				<hr>
				<h5>Data Guru</h5>
				<div class="mb-3">
					<label class="form-label">NIP</label>
					<input type="text" class="form-control" value="{{ $user->guru->nip }}" readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Tempat Lahir</label>
					<input type="text" class="form-control" value="{{ $user->guru->tempat_lahir }}" readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Tanggal Lahir</label>
					<input type="text" class="form-control"
						value="{{ $user->guru->tanggal_lahir ? \Carbon\Carbon::parse($user->guru->tanggal_lahir)->translatedFormat('d F Y') : '-' }}"
						readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Tempat Mengajar (Sekolah)</label>
					@if ($user->guru->sekolah && $user->guru->sekolah->count())
						@foreach ($user->guru->sekolah as $sekolah)
							<input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
						@endforeach
					@else
						<input type="text" class="form-control" value="-" readonly>
					@endif
				</div>
			@endif

			{{-- FORM STAFF GEREJA --}}
			@if ($user->role === 'staff-gereja' && $user->staffGereja)
				<hr>
				<h5>Data Pengurus Gereja</h5>
				<div class="mb-3">
					<label class="form-label">Gembala Sidang</label>
					<input type="text" class="form-control" value="{{ $user->staffGereja->gembala_sidang }}" readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Gereja</label>
					<input type="text" class="form-control"
						value="{{ optional($gerejas->firstWhere('id', $user->staffGereja->gereja_id))->nama ?? '-' }}" readonly>
				</div>
			@endif

			<div class="row mb-3">
				<div class="col-md-6">
					<label class="form-label">Dibuat Pada</label>
					<input type="text" class="form-control" value="{{ $user->created_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
				<div class="col-md-6">
					<label class="form-label">Diperbarui Pada</label>
					<input type="text" class="form-control" value="{{ $user->updated_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
			</div>
		</div>
	</div>
@endsection
