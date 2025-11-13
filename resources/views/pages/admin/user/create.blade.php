@extends("layouts.appadmin")

@section("title", "Tambah Pengguna")

@section("breadcrumb")
	<li class="breadcrumb-item"><a href="{{ route("admin.users.index") }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
@endsection

@section("content")
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Tambah Pengguna</h5>
		</div>
		<div class="card-body">
			<form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="mb-3">
					<label for="role" class="form-label">Role</label>
					<select id="role" name="role" class="form-select">
						<option value="">Pilih Role</option>
						<option value="guru">Guru</option>
						<option value="pengurus-gereja">Pengurus Gereja</option>
						<option value="admin">Admin</option>
					</select>
				</div>

				<div class="mb-3">
					<label>Nama</label>
					<input type="text" name="name" class="form-control" required>
				</div>

				<div class="mb-3">
					<label>Email</label>
					<input type="email" name="email" class="form-control" required>
				</div>

				<div class="mb-3">
					<label>Nomor Telepon</label>
					<input type="text" name="nomor_telepon" class="form-control">
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control @error("password") is-invalid @enderror" id="password" name="password"
						required placeholder="Masukkan password minimal 8 karakter">
					@error("password")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="password_confirmation" class="form-label">Konfirmasi Password</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
				</div>

				{{-- Bagian untuk GURU --}}
				<div id="form-guru" style="display:none;">
					<hr>
					<h5>Data Guru</h5>
					<div class="mb-3">
						<label>NIP</label>
						<input type="text" name="nip" class="form-control">
					</div>
					<div class="mb-3">
						<label>Tempat Lahir</label>
						<input type="text" name="tempat_lahir" class="form-control">
					</div>
					<div class="mb-3">
						<label>Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" class="form-control">
					</div>
					<div class="mb-3">
						<label>Sekolah</label>
						<select name="sekolah_id" class="form-select" {{ $sekolahs->isEmpty() ? "disabled" : "" }}>
							@if ($sekolahs->isEmpty())
								<option value="">Tidak ada sekolah tersedia</option>
							@else
								<option value="">Pilih Sekolah</option>
								@foreach ($sekolahs as $sekolah)
									<option value="{{ $sekolah->id }}">{{ $sekolah->nama }}</option>
								@endforeach
							@endif

						</select>
					</div>
				</div>

				{{-- Bagian untuk STAFF GEREJA --}}
				<div id="form-gereja" style="display:none;">
					<hr>
					<h5>Data Staff Gereja</h5>
					<div class="mb-3">
						<label>Gembala Sidang</label>
						<input type="text" name="gembala_sidang" class="form-control">
					</div>
					<div class="mb-3">
						<label>Gereja</label>
						<select name="gereja_id" class="form-select" {{ $gerejas->isEmpty() ? "disabled" : "" }}>
							@if ($gerejas->isEmpty())
								<option value="">Tidak ada gereja tersedia</option>
							@else
								<option value="">Pilih Gereja</option>
								@foreach ($gerejas as $gereja)
									<option value="{{ $gereja->id }}">{{ $gereja->nama }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>

				<div class="d-flex
							justify-content-between mt-4">
					<a href="{{ route("admin.sekolah.index") }}" class="btn btn-secondary">
						<i class="bi bi-arrow-left"></i> Batal
					</a>
					<button type="submit" class="btn btn-success">
						<i class="bi bi-save me-1"></i> Simpan
					</button>
				</div>
			</form>

			<script>
				const role = document.getElementById('role');
				const guruForm = document.getElementById('form-guru');
				const gerejaForm = document.getElementById('form-gereja');

				role.addEventListener('change', function() {
					guruForm.style.display = (this.value === 'guru') ? 'block' : 'none';
					gerejaForm.style.display = (this.value === 'pengurus-gereja') ? 'block' : 'none';
				});
			</script>
		</div>
	</div>
@endsection
