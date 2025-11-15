@extends('layouts.appadmin')

@section('title', 'Tambah Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Pengguna</h5>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="role" class="form-label">Peran</label>
                    <select id="role" name="role" class="form-select">
                        <option value="">Pilih Peran</option>
                        <option value="guru">Guru</option>
                        <option value="staff-gereja">Pengurus Gereja</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control" required
                        placeholder="Masukkan nomor telepon">
                    @error('nomor_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required placeholder="Masukkan password minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation" name="password_confirmation" required
                        placeholder="Masukkan ulang password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="profile_photo_path" class="form-label">Foto Profil</label>

                    {{-- Preview gambar di atas input --}}
                    <div class="text-center mb-3" id="photo-preview-container" style="display:none;">
                        <img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
                            style="max-width: 180px; border: 2px solid #dee2e6;">
                    </div>

                    <input type="file" class="form-control @error('profile_photo_path') is-invalid @enderror"
                        id="profile_photo_path" name="profile_photo_path" accept="image/*">
                    <small class="text-muted">Format gambar: jpg, png, jpeg. Maksimal ukuran: 2MB.</small>
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
                        <input type="text" name="nip" class="form-control"
                            placeholder="Masukkan NIP">
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" placeholder="Masukkan Tanggal Lahir">
                    </div>
                    <div class="mb-3">
                        <label for="sekolah_id" class="form-label">Tempat Mengajar (Sekolah)</label>
                        <select name="sekolah_id" class="form-select" {{ $sekolahs->isEmpty() ? 'disabled' : '' }}>
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
                        <label for="gembala_sidang" class="form-label">Gembala Sidang</label>
                        <input type="text" name="gembala_sidang" class="form-control" placeholder="Masukkan Gembala Sidang">
                    </div>
                    <div class="mb-3">
                        <label for="gereja_id" class="form-label">Gereja</label>
                        <select name="gereja_id" class="form-select" {{ $gerejas->isEmpty() ? 'disabled' : '' }}>
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

                role.addEventListener('change', function() {
                    guruForm.style.display = (this.value === 'guru') ? 'block' : 'none';
                    gerejaForm.style.display = (this.value === 'staff-gereja') ? 'block' : 'none';
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
            </script>

        </div>
    </div>
@endsection
