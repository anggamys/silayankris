@extends('layouts.appadmin')

@section('title', 'Ubah Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Data Pengguna</li>
@endsection

@section('content')
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Ubah Data Pengguna</h5>

			<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Batal
			</a>
		</div>

		<div class="card-body">
			<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				{{-- PERAN --}}
				<div class="mb-3">
					<label for="role" class="form-label">Peran</label>
					<x-select-input id="role" name="role" label="Peran" :options="[
					    'guru' => 'Guru',
					    'staff-gereja' => 'Pengurus Gereja',
					    'admin' => 'Admin',
					]" :selected="old('role', $user->role)"
						:searchable="false" />
				</div>

				<div class="mb-3">
					<label for="status" class="form-label">Status</label>
					<x-select-input id="status" name="status" label="Status" :options="[
					    'aktif' => 'Aktif',
					    'nonaktif' => 'Nonaktif',
					]" :selected="old('status', $user->status)"
						:searchable="false" />
				</div>

				{{-- NAMA --}}
				<div class="mb-3">
					<label class="form-label">Nama</label>
					<input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
				</div>

				{{-- EMAIL --}}
				<div class="mb-3">
					<label class="form-label">Email</label>
					<input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
				</div>

				{{-- NOMOR TELEPON --}}
				<div class="mb-3">
					<label class="form-label">Nomor Telepon</label>
					<input type="text" name="nomor_telepon" class="form-control"
						value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required>
				</div>
				{{-- PASSWORD --}}
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<div class="input-group">
						<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
							placeholder="Kosongkan jika tidak ingin mengubah">

						<button type="button" class="btn password-toggle-btn" id="togglePassword">
							<i class="bi bi-eye-slash"></i>
						</button>

					</div>

					@error('password')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- KONFIRMASI PASSWORD --}}
				<div class="mb-3">
					<label for="password_confirmation" class="form-label">Konfirmasi Password</label>

					<div class="input-group">
						<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
							id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru jika mengubah">

						<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
							<i class="bi bi-eye-slash"></i>
						</button>

					</div>

					@error('password_confirmation')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- FOTO PROFIL --}}
				<div class="mb-3">
					<label for="profile_photo_path" class="form-label">Foto Profil</label>

					{{-- Preview gambar lama --}}
					@php
						$photoFile = null;
						if ($user->profile_photo_path) {
						    $dir = pathinfo($user->profile_photo_path, PATHINFO_DIRNAME);
						    $filename = pathinfo($user->profile_photo_path, PATHINFO_FILENAME);
						    $photoFile = $dir !== '.' ? $dir . '/' . $filename . '.jpg' : $filename . '.jpg';
						}
						$photoPath = $photoFile ? public_path('storage/' . $photoFile) : null;
					@endphp
					<div class="text-center mb-3">
						@if ($photoFile && $photoPath && file_exists($photoPath))
							<img src="{{ asset('storage/' . $photoFile) }}" alt="Preview Foto Profil" class="img-thumbnail rounded"
								style="max-width: 180px; border: 2px solid #dee2e6;">
						@else
							<img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="Preview Foto Profil"
								class="img-thumbnail rounded" style="max-width: 180px; border: 2px solid #dee2e6;">
						@endif
					</div>

					{{-- Preview gambar baru di atas input --}}
					<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
						<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
							style="max-width: 180px; border: 2px solid #dee2e6;">
					</div>

					<input type="file" class="form-control @error('profile_photo_path') is-invalid @enderror" id="profile_photo_path"
						name="profile_photo_path" accept="image/*">
					<small class="text-muted">Format gambar: jpg, png, jpeg. Maksimal ukuran: 2MB. Kosongkan jika tidak ingin mengubah
						foto.</small>
					@error('profile_photo_path')
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
							value="{{ old('nip', $user->guru->nip ?? '') }}">
						@error('nip')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="tempat_lahir" class="form-label">Tempat Lahir</label>
						<input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir"
							value="{{ old('tempat_lahir', $user->guru->tempat_lahir ?? '') }}">
						@error('tempat_lahir')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" class="form-control"
							value="{{ old('tanggal_lahir', isset($user->guru->tanggal_lahir) && $user->guru->tanggal_lahir ? \Carbon\Carbon::parse($user->guru->tanggal_lahir)->format('Y-m-d') : '') }}"
							placeholder="Masukkan Tanggal Lahir">
						@error('tanggal_lahir')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div id="sekolah-wrapper">
						@php
							$oldSekolahs = old('sekolah_id');
							$guruSekolahs = isset($user->guru) ? $user->guru->sekolah->pluck('id')->toArray() : [];
							$sekolahList = is_array($oldSekolahs) && count($oldSekolahs) > 0 ? $oldSekolahs : $guruSekolahs;
						@endphp

						@if (is_array($sekolahList) && count($sekolahList) > 0)
							@foreach ($sekolahList as $idx => $sel)
								<div class="mb-2 sekolah-group" style="display: flex; flex-direction: row; justify-content: space-between;">
									<x-select-input id="sekolah{{ $idx }}" name="sekolah_id[]" label="Sekolah" :options="$sekolahs"
										:selected="$sel" dropdownClass="flex-fill" />
									@error('sekolah_id')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
									<button type="button" class="btn btn-danger remove-sekolah" {{ $idx == 0 ? 'disabled' : '' }}>
										&times;
									</button>
								</div>
							@endforeach
						@else
							<div class="mb-2 sekolah-group" style="display: flex; flex-direction: row; justify-content: space-between;">
								<x-select-input id="sekolah" name="sekolah_id[]" label="Sekolah" :options="$sekolahs" :selected="old('sekolah_id.0')"
									dropdownClass="flex-fill" />
								@error('sekolah_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<button type="button" class="btn btn-danger remove-sekolah" disabled>
									&times;
								</button>
							</div>
						@endif
					</div>

					{{-- Bagian untuk STAFF GEREJA --}}
					<div id="form-gereja" style="display:none;">
						<hr>
						<h5>Data Pengurus Gereja</h5>
						<div class="mb-3">
							<label for="gembala_sidang" class="form-label">Gembala Sidang</label>
							<input type="text" name="gembala_sidang" class="form-control" placeholder="Masukkan Gembala Sidang"
								value="{{ old('gembala_sidang', $user->staffGereja->gembala_sidang ?? '') }}">
							@error('gembala_sidang')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="gereja_id" class="form-label">Gereja</label>
							<x-select-input id="gereja" name="gereja_id" label="Gereja" :options="$gerejas" :selected="old('gereja_id', optional($user->staffGereja)->gereja_id)" />
							@error('gereja_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

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

					<script>
						const role = document.getElementById('role');
						const guruForm = document.getElementById('form-guru');
						const gerejaForm = document.getElementById('form-gereja');

						/**
						 * UTAMA: ganti seluruh script select/cloning yang lama dengan skrip dari create agar konsisten.
						 */

						function initSelectInput(id) {
							const hidden = document.getElementById(id);
							const btn = document.getElementById('btn-' + id);
							const listRoot = document.getElementById('list-' + id);
							const search = document.getElementById('search-' + id);

							if (!hidden || !btn || !listRoot) return;

							listRoot.querySelectorAll('.dropdown-item').forEach(item => {
								item.onclick = function(e) {
									const val = String(this.dataset.value ?? '');
									hidden.value = val;
									btn.textContent = this.textContent.trim();

									hidden.dispatchEvent(new Event('input', {
										bubbles: true
									}));
									hidden.dispatchEvent(new Event('change', {
										bubbles: true
									}));
								};
								item.style.display = '';
							});

							if (search) {
								search.oninput = function() {
									const keyword = this.value.toLowerCase();
									const allSelected = Array.from(document.querySelectorAll('input[type="hidden"][name="sekolah_id[]"]'))
										.map(i => i.value)
										.filter(v => v !== '');
									const currentValue = hidden.value;
									listRoot.querySelectorAll('.dropdown-item').forEach(item => {
										const val = item.dataset.value;
										const match = item.textContent.toLowerCase().includes(keyword);
										if (allSelected.includes(val) && val !== currentValue) {
											item.style.display = 'none';
										} else {
											item.style.display = match ? '' : 'none';
										}
									});
								};
							}

							hidden.oninput = updateSekolahOptions;
							hidden.onchange = updateSekolahOptions;
						}

						function updateSekolahOptions() {
							const selected = Array.from(document.querySelectorAll('input[type="hidden"][name="sekolah_id[]"]'))
								.map(i => String(i.value || ''))
								.filter(v => v !== '');
							document.querySelectorAll('.sekolah-group').forEach(group => {
								const hidden = group.querySelector('input[type="hidden"][name="sekolah_id[]"]');
								const current = hidden ? String(hidden.value || '') : '';
								group.querySelectorAll('.dropdown-item').forEach(item => {
									const val = String(item.dataset.value ?? '');
									if (val !== '' && selected.includes(val) && val !== current) {
										item.style.display = 'none';
									} else {
										item.style.display = '';
									}
								});
							});
						}

						function cloneSekolahGroup() {
							const wrapper = document.getElementById('sekolah-wrapper');
							const groups = wrapper.querySelectorAll('.sekolah-group');
							const base = groups[0];
							const idx = groups.length;
							const clone = base.cloneNode(true);
							const oldHidden = base.querySelector('input[type="hidden"][name="sekolah_id[]"]');
							if (!oldHidden) return;
							const oldId = oldHidden.id;
							const newId = oldId + '_' + idx;
							clone.innerHTML = clone.innerHTML
								.replaceAll(`btn-${oldId}`, `btn-${newId}`)
								.replaceAll(`dropdown-${oldId}`, `dropdown-${newId}`)
								.replaceAll(`search-${oldId}`, `search-${newId}`)
								.replaceAll(`list-${oldId}`, `list-${newId}`)
								.replaceAll(`id="${oldId}"`, `id="${newId}"`);
							wrapper.appendChild(clone);
							clone.querySelectorAll('.dropdown-item').forEach(i => i.style.display = '');
							const hiddenNew = clone.querySelector(`#${newId}`);
							if (hiddenNew) hiddenNew.value = '';
							const btnNew = clone.querySelector(`#btn-${newId}`);
							if (btnNew) {
								const placeholder = btnNew.getAttribute('data-placeholder') || 'Pilih Sekolah';
								btnNew.textContent = placeholder;
							}
							const removeBtn = clone.querySelector('.remove-sekolah');
							if (removeBtn) removeBtn.disabled = false;
							initSelectInput(newId);
							updateSekolahOptions();
						}

						document.addEventListener('DOMContentLoaded', function() {
							document.querySelectorAll('input[type="hidden"][name="sekolah_id[]"]').forEach(h => {
								if (h.id) initSelectInput(h.id);
							});
							const addBtn = document.getElementById('add-sekolah');
							if (addBtn) addBtn.addEventListener('click', cloneSekolahGroup);
							document.addEventListener('click', function(e) {
								if (e.target.classList.contains('remove-sekolah')) {
									const groups = document.querySelectorAll('.sekolah-group');
									if (groups.length > 1) {
										e.target.closest('.sekolah-group').remove();
										updateSekolahOptions();
									}
								}
							});
							updateSekolahOptions();
						});

						const role = document.getElementById('role');
						const guruForm = document.getElementById('form-guru');
						const gerejaForm = document.getElementById('form-gereja');

						role.addEventListener('change', function() {
							const isGuru = this.value === 'guru';
							guruForm.style.display = isGuru ? 'block' : 'none';
							gerejaForm.style.display = (this.value === 'staff-gereja') ? 'block' : 'none';
							const selects = document.querySelectorAll('select[name="sekolah_id[]"]');
							selects.forEach(s => {
								if (isGuru) {
									s.removeAttribute('disabled');
									s.setAttribute('required', 'required');
								} else {
									s.removeAttribute('required');
									s.setAttribute('disabled', 'disabled');
								}
							});
						});

						document.addEventListener("DOMContentLoaded", function() {
							const selectedRole = "{{ old('role', $user->role) }}";
							if (selectedRole === 'guru') {
								guruForm.style.display = 'block';
							}
							if (selectedRole === 'staff-gereja') {
								gerejaForm.style.display = 'block';
							}
							updateSekolahOptions();
						});

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

						const passwordInput = document.getElementById("password");
						const togglePassword = document.getElementById("togglePassword");
						togglePassword.addEventListener("click", function() {
							const type = passwordInput.type === "password" ? "text" : "password";
							passwordInput.type = type;
							this.querySelector("i").classList.toggle("bi-eye");
							this.querySelector("i").classList.toggle("bi-eye-slash");
						});

						const passwordConfirmInput = document.getElementById("password_confirmation");
						const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");
						togglePasswordConfirm.addEventListener("click", function() {
							const type = passwordConfirmInput.type === "password" ? "text" : "password";
							passwordConfirmInput.type = type;
							this.querySelector("i").classList.toggle("bi-eye");
							this.querySelector("i").classList.toggle("bi-eye-slash");
						});
					</script>

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
