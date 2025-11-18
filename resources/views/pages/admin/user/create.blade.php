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

			<a href="{{ route("admin.users.index") }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Batal
			</a>
		</div>
		<div class="card-body">
			<form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="mb-3">
					<label for="role" class="form-label">Peran</label>
					<select id="role" name="role" class="form-select">
						<option value="" disabled selected>Pilih Peran</option>
						<option value="guru" {{ old("role") == "guru" ? "selected" : "" }}>Guru</option>
						<option value="staff-gereja" {{ old("role") == "staff-gereja" ? "selected" : "" }}>Pengurus Gereja</option>
						<option value="admin" {{ old("role") == "admin" ? "selected" : "" }}>Admin</option>
					</select>
				</div>

				<div class="mb-3">
					<label for="name" class="form-label">Nama</label>
					<input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap"
						value="{{ old("name") }}">
					@error("name")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" required placeholder="Masukkan email"
						value="{{ old("email") }}">
					@error("email")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="nomor_telepon" class="form-label">Nomor Telepon</label>
					<input type="text" name="nomor_telepon" class="form-control" required placeholder="Masukkan nomor telepon"
						value="{{ old("nomor_telepon") }}">
					@error("nomor_telepon")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- PASSWORD --}}
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<div class="input-group">
						<input type="password" class="form-control @error("password") is-invalid @enderror" id="password" name="password"
							required placeholder="Masukkan password minimal 8 karakter">

						<button type="button" class="btn password-toggle-btn" id="togglePassword">
							<i class="bi bi-eye-slash"></i>
						</button>

					</div>

					@error("password")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- KONFIRMASI PASSWORD --}}
				<div class="mb-3">
					<label for="password_confirmation" class="form-label">Konfirmasi Password</label>

					<div class="input-group">
						<input type="password" class="form-control @error("password_confirmation") is-invalid @enderror"
							id="password_confirmation" name="password_confirmation" required placeholder="Masukkan ulang password">

						<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
							<i class="bi bi-eye-slash"></i>
						</button>

					</div>

					@error("password_confirmation")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- FOTO PROFIL --}}
				<div class="mb-3">
					<label for="profile_photo_path" class="form-label">Foto Profil</label>

					{{-- Preview gambar di atas input --}}
					<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
						<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
							style="max-width: 180px; border: 2px solid #dee2e6;">
					</div>

					<input type="file" class="form-control @error("profile_photo_path") is-invalid @enderror" id="profile_photo_path"
						name="profile_photo_path" accept="image/*">
					<small class="text-muted">Format gambar: jpg, png, jpeg. Maksimal ukuran: 2MB.</small>
					@error("profile_photo_path")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- Bagian untuk GURU --}}
				<div id="form-guru" style="display:none;">
					<hr>
					<h5>Data Guru</h5>
					<div class="mb-3">
						<label for="nip" class="form-label">NIP</label>
						<input type="text" name="nip" class="form-control" placeholder="Masukkan NIP"
							value="{{ old("nip") }}">
						@error("nip")
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="tempat_lahir" class="form-label">Tempat Lahir</label>
						<input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir"
							value="{{ old("tempat_lahir") }}">
						@error("tempat_lahir")
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" class="form-control" value="{{ old("tanggal_lahir") }}"
							placeholder="Masukkan Tanggal Lahir">
						@error("tanggal_lahir")
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label">Tempat Mengajar (Sekolah)</label>

						<div id="sekolah-wrapper">
							<div class="input-group mb-2 sekolah-group">
								<select name="sekolah_id[]" class="form-select">
									<option value="" disabled selected>Pilih Sekolah</option>
									@foreach ($sekolahs as $sekolah)
										<option value="{{ $sekolah->id }}">
											{{ $sekolah->nama }}
										</option>
									@endforeach
								</select>
								@error("sekolah_id")
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<button type="button" class="btn btn-danger remove-sekolah" disabled>
									&times;
								</button>
							</div>
						</div>

						<button type="button" id="add-sekolah" class="btn btn-primary btn-sm">
							+ Tambah Sekolah
						</button>
					</div>

					{{-- Bagian untuk STAFF GEREJA --}}
					<div id="form-gereja" style="display:none;">
						<hr>
						<h5>Data Pengurus Gereja</h5>
						<div class="mb-3">
							<label for="gembala_sidang" class="form-label">Gembala Sidang</label>
							<input type="text" name="gembala_sidang" class="form-control" placeholder="Masukkan Gembala Sidang"
								value="{{ old("gembala_sidang") }}">
							@error("gembala_sidang")
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="gereja_id" class="form-label">Gereja</label>
							<select name="gereja_id" class="form-select" {{ $gerejas->isEmpty() ? "disabled" : "" }}>
								@if ($gerejas->isEmpty())
									<option value="" disabled selected>Tidak ada gereja tersedia</option>
								@else
									<option value="" disabled selected>Pilih Gereja</option>
									@foreach ($gerejas as $gereja)
										<option value="{{ $gereja->id }}" {{ old("gereja_id") == $gereja->id ? "selected" : "" }}>
											{{ $gereja->nama }}
										</option>
									@endforeach
								@endif
							</select>
							@error("gereja_id")
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-primary">
							<i class="bi bi-save me-1"></i> Simpan
						</button>
					</div>
			</form>

			<style>
				.password-toggle-btn {
					border-color: #ced4da !important;
					background-color: #f8f9fa !important;
				}

				.password-toggle-btn:hover {
					background-color: #e9ecef !important;
					border-color: #c5cbd2 !important;
				}
			</style>

			{{-- SCRIPT --}}
			<script>
				// ======== Tambah/Hapus Sekolah ========
				document.getElementById('add-sekolah').addEventListener('click', function() {
					const wrapper = document.getElementById('sekolah-wrapper');

					const newGroup = document.createElement('div');
					newGroup.classList.add('input-group', 'mb-2', 'sekolah-group');

					newGroup.innerHTML = `
			<select name="sekolah_id[]" class="form-select">
				<option value="" disabled selected>Pilih Sekolah</option>
				@foreach ($sekolahs as $sekolah)
					<option value="{{ $sekolah->id }}">{{ $sekolah->nama }}</option>
				@endforeach
			</select>
			<button type="button" class="btn btn-danger remove-sekolah">&times;</button>
		`;

					wrapper.appendChild(newGroup);
					setTimeout(updateSekolahOptions, 100); // update opsi setelah tambah
				});

				// Hapus input (kecuali input pertama)
				document.addEventListener('click', function(e) {
					if (e.target.classList.contains('remove-sekolah') && !e.target.disabled) {
						e.target.closest('.sekolah-group').remove();
						setTimeout(updateSekolahOptions, 100); // update opsi setelah hapus
					}
				});


				// ======== Hilangkan opsi sekolah yang sudah dipilih di input lain ========
				function updateSekolahOptions() {
					const selects = document.querySelectorAll('select[name="sekolah_id[]"]');
					const selectedValues = Array.from(selects)
						.map(select => select.value)
						.filter(val => val !== "");

					selects.forEach(select => {
						// Simpan value yang sedang dipilih agar tidak hilang
						const currentValue = select.value;
						// Ambil semua option dari template
						const sekolahOptions = [
							'<option value="" disabled' + (currentValue === '' ? ' selected' : '') +
							'>Pilih Sekolah</option>',
							@foreach ($sekolahs as $sekolah)
								(selectedValues.includes('{{ $sekolah->id }}') && currentValue !==
									'{{ $sekolah->id }}') ? '' : '<option value="{{ $sekolah->id }}"' + (
									currentValue === '{{ $sekolah->id }}' ? ' selected' : '') +
								'>{{ $sekolah->nama }}</option>',
							@endforeach
						].join('');
						// Render ulang option
						select.innerHTML = sekolahOptions.replace(/,\s*/g, '');
						// Set value agar tidak hilang
						select.value = currentValue;
					});
				}

				document.addEventListener('change', function(e) {
					if (e.target && e.target.name === "sekolah_id[]") {
						updateSekolahOptions();
					}
				});

				document.addEventListener("DOMContentLoaded", function() {
					updateSekolahOptions();
				});

				const role = document.getElementById('role');
				const guruForm = document.getElementById('form-guru');
				const gerejaForm = document.getElementById('form-gereja');

				// Saat user mengubah pilihan
				role.addEventListener('change', function() {
					guruForm.style.display = (this.value === 'guru') ? 'block' : 'none';
					gerejaForm.style.display = (this.value === 'staff-gereja') ? 'block' : 'none';
					updateSekolahOptions();
				});

				// ======== Auto-show berdasarkan old('role') ==========
				document.addEventListener("DOMContentLoaded", function() {
					const selectedRole = "{{ old("role") }}"; // Blade inject

					if (selectedRole === 'guru') {
						guruForm.style.display = 'block';
					}

					if (selectedRole === 'staff-gereja') {
						gerejaForm.style.display = 'block';
					}
					updateSekolahOptions();
				});

				// ======== Preview Foto Profil ==========
				const photoInput = document.getElementById('profile_photo_path');
				const previewContainer = document.getElementById('photo-preview-container');
				const previewImage = document.getElementById('photo-preview');

				photoInput.addEventListener('change', function(event) {
					const file = event.target.files[0];
					if (file) {
						const reader = new FileReader();
						reader.onload = function(e) {
							previewImage.src = e.target.result;
							previewContainer.style.display = 'block';
						};
						reader.readAsDataURL(file);
					} else {
						previewContainer.style.display = 'none';
					}
				});

				// ======== Show / Hide Password ==========
				const passwordInput = document.getElementById("password");
				const togglePassword = document.getElementById("togglePassword");

				togglePassword.addEventListener("click", function() {
					const type = passwordInput.type === "password" ? "text" : "password";
					passwordInput.type = type;

					this.querySelector("i").classList.toggle("bi-eye");
					this.querySelector("i").classList.toggle("bi-eye-slash");
				});

				// ======== Show / Hide Password Confirmation ==========
				const passwordConfirmInput = document.getElementById("password_confirmation");
				const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");

				togglePasswordConfirm.addEventListener("click", function() {
					const type = passwordConfirmInput.type === "password" ? "text" : "password";
					passwordConfirmInput.type = type;

					this.querySelector("i").classList.toggle("bi-eye");
					this.querySelector("i").classList.toggle("bi-eye-slash");
				});
			</script>

		</div>
	</div>
@endsection
