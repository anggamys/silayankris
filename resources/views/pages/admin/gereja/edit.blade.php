@extends('layouts.appadmin')

@section('title', 'Ubah Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">Data Gereja</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Ubah Data Gereja</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Ubah Data Gereja</h5>

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
                        <input type="hidden" name="kab_kota" id="kab_kota"
                            value="{{ old('kab_kota', $gereja->kab_kota) }}">

                        <div class="dropdown">
                            <button id="btn-kota" class="btn btn-light form-control text-start dropdown-toggle w-full"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Kota
                            </button>
                            <ul class="dropdown-menu w-100" id="dropdown-kota" style="max-height:150px; overflow-y:auto;">
                                <li><a class="dropdown-item py-1" data-value="Surabaya">Surabaya</a></li>
                            </ul>
                        </div>

                        @error('kab_kota')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kecamatan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="hidden" name="kecamatan" id="kecamatan"
                            value="{{ old('kecamatan', $gereja->kecamatan) }}">

                        <button id="btn-kecamatan" class="btn btn-light form-control text-start dropdown-toggle"
                            data-bs-toggle="dropdown">
                            Pilih Kecamatan
                        </button>
                        <ul class="dropdown-menu w-full" id="dropdown-kecamatan" style="max-height:150px; overflow-y:auto;">
                            <li><span class="dropdown-item-text text-muted">Pilih kota dulu</span></li>
                        </ul>

                        @error('kecamatan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Kelurahan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelurahan / Desa</label>

                        <input type="hidden" name="kel_desa" id="kel_desa"
                            value="{{ old('kel_desa', $gereja->kel_desa) }}">

                        <button id="btn-kelurahan" class="btn btn-light form-control text-start dropdown-toggle"
                            data-bs-toggle="dropdown">
                            Pilih Kelurahan
                        </button>

                        <ul class="dropdown-menu w-full" id="dropdown-kelurahan" style="max-height:150px; overflow-y:auto;">
                            <li><span class="dropdown-item-text text-muted">Pilih kecamatan dulu</span></li>
                        </ul>

                        @error('kel_desa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                            value="{{ old('nomor_telepon', $gereja->nomor_telepon) }}"
                            placeholder="Masukkan nomor telepon" maxlength="20">
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
                const hiddenKota = document.getElementById("kab_kota");
                const hiddenKecamatan = document.getElementById("kecamatan");
                const hiddenKelurahan = document.getElementById("kel_desa");

                const btnKota = document.getElementById("btn-kota");
                const btnKecamatan = document.getElementById("btn-kecamatan");
                const btnKelurahan = document.getElementById("btn-kelurahan");

                const dropdownKota = document.getElementById("dropdown-kota");
                const dropdownKecamatan = document.getElementById("dropdown-kecamatan");
                const dropdownKelurahan = document.getElementById("dropdown-kelurahan");

                const oldKota = "{{ old('kab_kota', $gereja->kab_kota ?? '') }}";
                const oldKecamatan = "{{ old('kecamatan', $gereja->kecamatan ?? '') }}";
                const oldKelurahan = "{{ old('kel_desa', $gereja->kel_desa ?? '') }}";

                // 1. SET TEXT TOMBOL SAAT EDIT
                if (oldKota) btnKota.textContent = oldKota;
                if (oldKecamatan) btnKecamatan.textContent = oldKecamatan;
                if (oldKelurahan) btnKelurahan.textContent = oldKelurahan;

                // 2. EVENT PILIH KOTA
                dropdownKota.querySelectorAll(".dropdown-item").forEach(item => {
                    item.addEventListener("click", function() {
                        const value = this.dataset.value;

                        hiddenKota.value = value;
                        btnKota.textContent = value;

                        // Reset kecamatan & kelurahan
                        btnKecamatan.textContent = "Pilih Kecamatan";
                        hiddenKecamatan.value = "";
                        dropdownKecamatan.innerHTML = `<li><span class="dropdown-item-text">Loading...</span></li>`;

                        btnKelurahan.textContent = "Pilih Kelurahan";
                        hiddenKelurahan.value = "";
                        dropdownKelurahan.innerHTML =
                            `<li><span class="dropdown-item-text">Pilih kecamatan dulu</span></li>`;

                        loadKecamatan(value);
                    });
                });

                // 3. LOAD KECAMATAN (AJAX)
                function loadKecamatan(kota, callback = null) {
                    fetch(`/admin/get-kecamatan?kota=${kota}`)
                        .then(res => res.json())
                        .then(data => {
                            let html = "";
                            data.forEach(kec => {
                                html += `<li><a class="dropdown-item py-1" data-value="${kec}">${kec}</a></li>`;
                            });
                            dropdownKecamatan.innerHTML = html;

                            attachEventKecamatan();

                            if (callback) callback();
                        });
                }

                // 4. EVENT PILIH KECAMATAN
                function attachEventKecamatan() {
                    dropdownKecamatan.querySelectorAll(".dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.dataset.value;
                            hiddenKecamatan.value = value;
                            btnKecamatan.textContent = value;

                            // Reset kelurahan
                            btnKelurahan.textContent = "Pilih Kelurahan";
                            hiddenKelurahan.value = "";
                            dropdownKelurahan.innerHTML =
                                `<li><span class="dropdown-item-text">Loading...</span></li>`;

                            loadKelurahan(hiddenKota.value, value);
                        });
                    });
                }

                // 5. LOAD KELURAHAN (AJAX)
                function loadKelurahan(kota, kecamatan, callback = null) {
                    fetch(`/admin/get-kelurahan?kota=${kota}&kecamatan=${kecamatan}`)
                        .then(res => res.json())
                        .then(data => {
                            let html = "";
                            data.forEach(kel => {
                                html += `<li><a class="dropdown-item py-1" data-value="${kel}">${kel}</a></li>`;
                            });
                            dropdownKelurahan.innerHTML = html;

                            attachEventKelurahan();

                            if (callback) callback();
                        });
                }

                // 6. EVENT PILIH KELURAHAN
                function attachEventKelurahan() {
                    dropdownKelurahan.querySelectorAll(".dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.dataset.value;
                            hiddenKelurahan.value = value;
                            btnKelurahan.textContent = value;
                        });
                    });
                }

                // 7. LOAD DATA SAAT EDIT FORM
                if (oldKota) {
                    loadKecamatan(oldKota, function() {
                        if (oldKecamatan) {
                            // Set tombol kecamatan
                            btnKecamatan.textContent = oldKecamatan;
                            hiddenKecamatan.value = oldKecamatan;

                            loadKelurahan(oldKota, oldKecamatan, function() {
                                if (oldKelurahan) {
                                    btnKelurahan.textContent = oldKelurahan;
                                    hiddenKelurahan.value = oldKelurahan;
                                }
                            });
                        }
                    });
                }
            </script>
        </div>
    </div>
@endsection
