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
                    <label class="form-label">Peran</label>
                    <select id="role" name="role" class="form-select">
                        <option value="" disabled selected>Pilih Peran</option>
                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="staff-gereja" {{ $user->role == 'staff-gereja' ? 'selected' : '' }}>Pengurus Gereja
                        </option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                        required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                        required>
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
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Kosongkan jika tidak ingin mengubah">

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
                            id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password baru jika mengubah">

                        <button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
                            <i class="bi bi-eye-slash"></i>
                        </button>

                    </div>

                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- FOTO --}}
                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>

                    {{-- Preview Foto Lama --}}
                    @if (!empty($user->profile_photo_path))
                        <div class="text-center mb-3" id="old-photo-container">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="img-thumbnail rounded"
                                style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
                        </div>
                    @endif

                    {{-- Preview foto baru --}}
                    <div class="text-center mb-3" id="photo-preview-container" style="display:none;">
                        <img id="photo-preview" src="#" class="img-thumbnail rounded"
                            style="width: 180px; height: 240px; object-fit: cover;">
                    </div>

                    <input type="file" id="profile_photo_path" name="profile_photo_path" class="form-control"
                        accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. Format: jpg, png, jpeg. Maksimal:
                        2MB. Ukuran pas foto: 3x4.</small>
                </div>

                {{-- FORM GURU --}}
                <div id="form-guru" style="display:none;">
                    <hr>
                    <h5>Data Guru</h5>

                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control"
                            value="{{ old('nip', $user->guru->nip ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $user->guru->tempat_lahir ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir', isset($user->guru->tanggal_lahir) && $user->guru->tanggal_lahir ? \Carbon\Carbon::parse($user->guru->tanggal_lahir)->format('Y-m-d') : '') }}">

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Mengajar (Sekolah)</label>

                        <div id="sekolah-wrapper">
                            @php
                                $oldSekolahs = old('sekolah_id');
                                $guruSekolahs = isset($user->guru) ? $user->guru->sekolah->pluck('id')->toArray() : [];
                                $sekolahList =
                                    is_array($oldSekolahs) && count($oldSekolahs) > 0 ? $oldSekolahs : $guruSekolahs;
                            @endphp

                            @if (is_array($sekolahList) && count($sekolahList) > 0)
                                @foreach ($sekolahList as $idx => $sel)
                                    <div class="input-group mb-2 sekolah-group">
                                        <select name="sekolah_id[]" class="form-select">
                                            <option value="" disabled {{ $sel == '' ? 'selected' : '' }}>Pilih
                                                Sekolah</option>
                                            @foreach ($sekolahs as $sekolah)
                                                <option value="{{ $sekolah->id }}"
                                                    {{ $sel == $sekolah->id ? 'selected' : '' }}>
                                                    {{ $sekolah->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sekolah_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-danger remove-sekolah"
                                            {{ $idx == 0 ? 'disabled' : '' }}>&times;</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2 sekolah-group">
                                    <select name="sekolah_id[]" class="form-select">
                                        <option value="" disabled selected>Pilih Sekolah</option>
                                        @foreach ($sekolahs as $sekolah)
                                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('sekolah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button type="button" class="btn btn-danger remove-sekolah" disabled>&times;</button>
                                </div>
                            @endif
                        </div>

                        <button type="button" id="add-sekolah" class="btn btn-primary btn-sm">
                            + Tambah Sekolah
                        </button>
                    </div>
                </div>

                {{-- FORM STAFF GEREJA --}}
                <div id="form-gereja" style="display:none;">
                    <hr>
                    <h5>Data Staff Gereja</h5>

                    <div class="mb-3">
                        <label class="form-label">Gembala Sidang</label>
                        <input type="text" name="gembala_sidang" class="form-control"
                            value="{{ old('gembala_sidang', $user->staffGereja->gembala_sidang ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gereja</label>
                        <select name="gereja_id" class="form-select">
                            <option value="" disabled selected>Pilih Gereja</option>
                            @foreach ($gerejas as $gereja)
                                <option value="{{ $gereja->id }}"
                                    {{ optional($user->staffGereja)->gereja_id == $gereja->id ? 'selected' : '' }}>
                                    {{ $gereja->nama }}
                                </option>
                            @endforeach
                        </select>
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

            <script>
                const role = document.getElementById('role');
                const guruForm = document.getElementById('form-guru');
                const gerejaForm = document.getElementById('form-gereja');

                // Tampilkan form sesuai role user saat halaman dibuka
                function toggleForms() {
                    guruForm.style.display = (role.value === 'guru') ? 'block' : 'none';
                    gerejaForm.style.display = (role.value === 'staff-gereja') ? 'block' : 'none';
                }

                toggleForms();
                role.addEventListener('change', toggleForms);

                // ======== Tambah/Hapus Sekolah (mirip create view) ========
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

                // PREVIEW FOTO BARU + HILANGKAN FOTO LAMA
                const photoInput = document.getElementById('profile_photo_path');
                const previewContainer = document.getElementById('photo-preview-container');
                const previewImage = document.getElementById('photo-preview');
                const oldPhoto = document.getElementById('old-photo-container');

                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        // Hilangkan foto lama
                        if (oldPhoto) oldPhoto.style.display = 'none';

                        const reader = new FileReader();
                        reader.onload = (e) => {
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
