@extends('layouts.appadmin')

@section('title', 'Ubah Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">Data Gereja</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Gereja</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Gereja</h5>

            <a href="{{ route('admin.gereja.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.gereja.update', $gereja->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Nama Gereja</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $gereja->nama) }}" placeholder="Masukkan nama gereja">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Berdiri --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Berdiri</label>
                    <input type="date" name="tanggal_berdiri"
                        class="form-control @error('tanggal_berdiri') is-invalid @enderror"
                        value="{{ old('tanggal_berdiri', optional($gereja->tanggal_berdiri)->format('Y-m-d')) }}">
                    @error('tanggal_berdiri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Bergabung Sinode --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Bergabung Sinode</label>
                    <input type="date" name="tanggal_bergabung_sinode"
                        class="form-control @error('tanggal_bergabung_sinode') is-invalid @enderror"
                        value="{{ old('tanggal_bergabung_sinode', optional($gereja->tanggal_bergabung_sinode)->format('Y-m-d')) }}">
                    @error('tanggal_bergabung_sinode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat', $gereja->alamat) }}" placeholder="Masukkan alamat lengkap">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="row">
                    {{-- Kota --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select name="kab_kota" id="kab_kota" class="form-select">
                            <option value="">Pilih Kota</option>
                            <option value="Surabaya"
                                {{ old('kab_kota', $gereja->kab_kota) == 'Surabaya' ? 'selected' : '' }}>
                                Surabaya
                            </option>
                        </select>
                        @error('kab_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kecamatan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select">
                            <option value="{{ old('kecamatan', $gereja->kecamatan) }}">
                                {{ old('kecamatan', $gereja->kecamatan) }}
                            </option>
                        </select>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelurahan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelurahan / Desa</label>
                        <select name="kel_desa" id="kel_desa" class="form-select">
                            <option value="{{ old('kel_desa', $gereja->kel_desa) }}">
                                {{ old('kel_desa', $gereja->kel_desa) }}
                            </option>
                        </select>
                        @error('kel_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Jarak Gereja Lain --}}
                <div class="mb-3">
                    <label class="form-label">Jarak Gereja Lain</label>
                    <input type="text" name="jarak_gereja_lain"
                        class="form-control @error('jarak_gereja_lain') is-invalid @enderror"
                        value="{{ old('jarak_gereja_lain', $gereja->jarak_gereja_lain) }}"
                        placeholder="Contoh: 2 km dari GKP terdekat">
                    @error('jarak_gereja_lain')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kontak --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $gereja->email) }}" placeholder="Masukkan email gereja">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon"
                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                            value="{{ old('nomor_telepon', $gereja->nomor_telepon) }}" placeholder="Masukkan nomor telepon"
                            maxlength="20">
                        @error('nomor_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nama Pendeta --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pendeta</label>
                    <input type="text" name="nama_pendeta"
                        class="form-control @error('nama_pendeta') is-invalid @enderror"
                        value="{{ old('nama_pendeta', $gereja->nama_pendeta) }}" placeholder="Masukkan nama pendeta">
                    @error('nama_pendeta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Status Gereja</label>
                    <select name="status_gereja" class="form-select @error('status_gereja') is-invalid @enderror">
                        <option value="">Pilih Status</option>
                        <option value="permanen"
                            {{ old('status_gereja', $gereja->status_gereja) == 'permanen' ? 'selected' : '' }}>Permanen
                        </option>
                        <option value="semi-permanen"
                            {{ old('status_gereja', $gereja->status_gereja) == 'semi-permanen' ? 'selected' : '' }}>
                            Semi-permanen</option>
                        <option value="tidak-permanen"
                            {{ old('status_gereja', $gereja->status_gereja) == 'tidak-permanen' ? 'selected' : '' }}>Tidak
                            permanen</option>
                    </select>
                    @error('status_gereja')
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

            <script>
                const kotaSelect = document.getElementById("kab_kota");
                const kecSelect = document.getElementById("kecamatan");
                const kelSelect = document.getElementById("kel_desa");

                // Nilai lama (untuk edit)
                const oldKota = "{{ old('kab_kota', $gereja->kab_kota ?? '') }}";
                const oldKecamatan = "{{ old('kecamatan', $gereja->kecamatan ?? '') }}";
                const oldKelurahan = "{{ old('kel_desa', $gereja->kel_desa ?? '') }}";

                // 1. LOAD KECAMATAN SAAT EDIT
                function loadKecamatan(kota, callback = null) {
                    kecSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                    kelSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;

                    if (!kota) return;

                    fetch(`/get-kecamatan?kota=${kota}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(kec => {
                                kecSelect.innerHTML +=
                                    `<option value="${kec}" ${kec === oldKecamatan ? 'selected' : ''}>${kec}</option>`;
                            });

                            if (callback) callback();
                        });
                }

                // 2. LOAD KELURAHAN SAAT EDIT
                function loadKelurahan(kota, kecamatan) {
                    kelSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;

                    if (!kecamatan) return;

                    fetch(`/get-kelurahan?kota=${kota}&kecamatan=${kecamatan}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(kel => {
                                kelSelect.innerHTML +=
                                    `<option value="${kel}" ${kel === oldKelurahan ? 'selected' : ''}>${kel}</option>`;
                            });
                        });
                }

                // EVENT CHANGE (CREATE MODE)
                kotaSelect.addEventListener("change", function() {
                    loadKecamatan(this.value);
                });

                kecSelect.addEventListener("change", function() {
                    loadKelurahan(kotaSelect.value, this.value);
                });

                // AUTO LOAD SAAT EDIT
                if (oldKota) {
                    kotaSelect.value = oldKota;
                    loadKecamatan(oldKota, function() {
                        loadKelurahan(oldKota, oldKecamatan);
                    });
                }
            </script>

        </div>
    </div>
@endsection
