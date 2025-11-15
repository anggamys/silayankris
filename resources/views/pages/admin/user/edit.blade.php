@extends('layouts.appadmin')

@section('title', 'Ubah Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Pengguna</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Pengguna</h5>
            
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
                        <option value="">Pilih Peran</option>
                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="staff-gereja" {{ $user->role == 'staff-gereja' ? 'selected' : '' }}>Pengurus Gereja
                        </option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
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
                    <label class="form-label">Password (Opsional)</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                {{-- CONFIRM --}}
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password baru jika mengubah">
                </div>

                {{-- FOTO --}}
                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>

                    {{-- Preview Foto Lama --}}
                    @if ($user->profile_photo_path)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="img-thumbnail rounded"
                                style="max-width: 180px; border: 2px solid #dee2e6;">
                        </div>
                    @endif

                    {{-- Preview foto baru --}}
                    <div class="text-center mb-3" id="photo-preview-container" style="display:none;">
                        <img id="photo-preview" src="#" class="img-thumbnail rounded" style="max-width: 180px;">
                    </div>

                    <input type="file" id="profile_photo_path" name="profile_photo_path" class="form-control"
                        accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
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
                        <select name="sekolah_id" class="form-select">
                            <option value="">Pilih Sekolah</option>
                            @foreach ($sekolahs as $sekolah)
                                <option value="{{ $sekolah->id }}"
                                    {{ optional($user->guru)->sekolah_id == $sekolah->id ? 'selected' : '' }}>
                                    {{ $sekolah->nama }} 
                                </option>
                            @endforeach
                        </select>
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
                            <option value="">Pilih Gereja</option>
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

                // Preview foto baru
                const photoInput = document.getElementById('profile_photo_path');
                const previewContainer = document.getElementById('photo-preview-container');
                const previewImage = document.getElementById('photo-preview');

                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
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
            </script>

        </div>
    </div>
@endsection
