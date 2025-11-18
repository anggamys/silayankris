@extends('layouts.appadmin')

@section('title', 'Tambah Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">Data Gereja</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data Gereja</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Data Gereja</h5>

            <a href="{{ route('admin.gereja.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.gereja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Nama Gereja</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" placeholder="Masukkan nama gereja">

                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Berdiri --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Berdiri</label>
                    <input type="date" name="tanggal_berdiri"
                        class="form-control @error('tanggal_berdiri') is-invalid @enderror"
                        value="{{ old('tanggal_berdiri') }}">

                    @error('tanggal_berdiri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Bergabung Sinode --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Bergabung Sinode</label>
                    <input type="date" name="tanggal_bergabung_sinode"
                        class="form-control @error('tanggal_bergabung_sinode') is-invalid @enderror"
                        value="{{ old('tanggal_bergabung_sinode') }}">

                    @error('tanggal_bergabung_sinode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat') }}" placeholder="Masukkan alamat lengkap">

                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Kota --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kabupaten/Kota</label>

                        <input type="hidden" name="kab_kota" id="kab_kota">

                        <div class="dropdown">
                            <button id="btn-kota" class="btn btn-light form-control text-start dropdown-toggle w-full"
                                data-bs-toggle="dropdown" aria-expanded="false" >
                                Pilih Kota
                            </button>

                            <ul class="dropdown-menu w-100" id="dropdown-kota" style="max-height:150px; overflow-y:auto;">
                                <li><a class="dropdown-item py-1" data-value="Surabaya">Surabaya</a></li>
                                {{-- Kalau mau dinamis, Anda bisa looping di sini --}}
                            </ul>
                        </div>

                        @error('kab_kota')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kecamatan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>

                        <input type="hidden" name="kecamatan" id="kecamatan">

                        <button id="btn-kecamatan" class="btn btn-light form-control text-start dropdown-toggle"
                            data-bs-toggle="dropdown">
                            Pilih Kecamatan
                        </button>

                        <ul class="dropdown-menu w-full" id="dropdown-kecamatan" style="max-height:150px; overflow-y:auto;">
                            <li><span class="dropdown-item-text text-muted">Pilih kota terlebih dahulu</span></li>
                        </ul>

                        @error('kecamatan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Kelurahan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelurahan / Desa</label>

                        <input type="hidden" name="kel_desa" id="kel_desa">

                        <button id="btn-kelurahan" class="btn btn-light form-control text-start dropdown-toggle"
                            data-bs-toggle="dropdown">
                            Pilih Kelurahan
                        </button>

                        <ul class="dropdown-menu w-full" id="dropdown-kelurahan" style="max-height:150px; overflow-y:auto;">
                            <li><span class="dropdown-item-text text-muted">Pilih kecamatan terlebih dahulu</span></li>
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
                        value="{{ old('jarak_gereja_lain') }}" placeholder="Contoh: 2 km dari GKP terdekat">

                    @error('jarak_gereja_lain')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kontak --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Masukkan email gereja">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon"
                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                            value="{{ old('nomor_telepon') }}" placeholder="Masukkan nomor telepon" maxlength="20">

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
                        value="{{ old('nama_pendeta') }}" placeholder="Masukkan nama pendeta">

                    @error('nama_pendeta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Status Gereja</label>
                    <select name="status_gereja" class="form-select @error('status_gereja') is-invalid @enderror">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="permanen" {{ old('status_gereja') == 'permanen' ? 'selected' : '' }}>Permanen
                        </option>
                        <option value="semi-permanen" {{ old('status_gereja') == 'semi-permanen' ? 'selected' : '' }}>
                            Semi-permanen</option>
                        <option value="tidak-permanen" {{ old('status_gereja') == 'tidak-permanen' ? 'selected' : '' }}>
                            Tidak permanen</option>
                    </select>

                    @error('status_gereja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- JSON Fields --}}
                <h5 class="mt-4 fw-bold">Data Jemaat</h5>
                <div class="row">
                    {{-- Jumlah Umat --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Umat</label>

                        <div class="input-group mb-1">
                            <input type="number" name="jumlah_umat[laki_laki]" class="form-control"
                                placeholder="Jumlah laki-laki" value="{{ old('jumlah_umat.laki_laki', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Laki-laki
                            </span>
                        </div>
                        @error('jumlah_umat.laki_laki')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="input-group">
                            <input type="number" name="jumlah_umat[perempuan]" class="form-control"
                                placeholder="Jumlah perempuan" value="{{ old('jumlah_umat.perempuan', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Perempuan
                            </span>
                        </div>
                        @error('jumlah_umat.perempuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah Majelis --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Majelis</label>

                        <div class="input-group mb-1">
                            <input type="number" name="jumlah_majelis[laki_laki]" class="form-control"
                                placeholder="Jumlah laki-laki" value="{{ old('jumlah_majelis.laki_laki', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Laki-laki
                            </span>
                        </div>
                        @error('jumlah_majelis.laki_laki')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="input-group">
                            <input type="number" name="jumlah_majelis[perempuan]" class="form-control"
                                placeholder="Jumlah perempuan" value="{{ old('jumlah_majelis.perempuan', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Perempuan
                            </span>
                        </div>
                        @error('jumlah_majelis.perempuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah Pemuda --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Pemuda</label>

                        <div class="input-group mb-1">
                            <input type="number" name="jumlah_pemuda[laki_laki]" class="form-control"
                                placeholder="Jumlah laki-laki" value="{{ old('jumlah_pemuda.laki_laki', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Laki-laki
                            </span>
                        </div>
                        @error('jumlah_pemuda.laki_laki')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="input-group">
                            <input type="number" name="jumlah_pemuda[perempuan]" class="form-control"
                                placeholder="Jumlah perempuan" value="{{ old('jumlah_pemuda.perempuan', 0) }}"
                                min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Perempuan
                            </span>
                        </div>
                        @error('jumlah_pemuda.perempuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah Guru Sekolah Minggu --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Guru Sekolah Minggu</label>

                        <div class="input-group mb-1">
                            <input type="number" name="jumlah_guru_sekolah_minggu[laki_laki]" class="form-control"
                                placeholder="Jumlah laki-laki"
                                value="{{ old('jumlah_guru_sekolah_minggu.laki_laki', 0) }}" min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Laki-laki
                            </span>
                        </div>
                        @error('jumlah_guru_sekolah_minggu.laki_laki')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="input-group">
                            <input type="number" name="jumlah_guru_sekolah_minggu[perempuan]" class="form-control"
                                placeholder="Jumlah perempuan"
                                value="{{ old('jumlah_guru_sekolah_minggu.perempuan', 0) }}" min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Perempuan
                            </span>
                        </div>
                        @error('jumlah_guru_sekolah_minggu.perempuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah Murid Sekolah Minggu --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jumlah Murid Sekolah Minggu</label>

                        <div class="input-group mb-1">
                            <input type="number" name="jumlah_murid_sekolah_minggu[laki_laki]" class="form-control"
                                placeholder="Jumlah laki-laki"
                                value="{{ old('jumlah_murid_sekolah_minggu.laki_laki', 0) }}" min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Laki-laki
                            </span>
                        </div>
                        @error('jumlah_murid_sekolah_minggu.laki_laki')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="input-group">
                            <input type="number" name="jumlah_murid_sekolah_minggu[perempuan]" class="form-control"
                                placeholder="Jumlah perempuan"
                                value="{{ old('jumlah_murid_sekolah_minggu.perempuan', 0) }}" min="0">
                            <span class="input-group-text d-flex align-items-center justify-content-center"
                                style="width: 30%">
                                Perempuan
                            </span>
                        </div>
                        @error('jumlah_murid_sekolah_minggu.perempuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                // Handle Dropdown Kota
                document.querySelectorAll("#dropdown-kota .dropdown-item").forEach(item => {
                    item.addEventListener("click", function() {
                        const value = this.getAttribute("data-value");

                        document.getElementById("kab_kota").value = value;
                        document.getElementById("btn-kota").textContent = value;

                        // Reset kecamatan & kelurahan
                        document.getElementById("btn-kecamatan").textContent = "Pilih Kecamatan";
                        document.getElementById("kecamatan").value = "";
                        document.getElementById("dropdown-kecamatan").innerHTML =
                            `<li><span class="dropdown-item-text">Loading...</span></li>`;

                        document.getElementById("btn-kelurahan").textContent = "Pilih Kelurahan";
                        document.getElementById("kel_desa").value = "";
                        document.getElementById("dropdown-kelurahan").innerHTML =
                            `<li><span class="dropdown-item-text">Pilih kecamatan terlebih dahulu</span></li>`;

                        // Fetch Kecamatan
                        fetch(`/get-kecamatan?kota=${value}`)
                            .then(res => res.json())
                            .then(data => {
                                let list = "";
                                data.forEach(kec => {
                                    list +=
                                        `<li><a class="dropdown-item py-1" data-value="${kec}">${kec}</a></li>`;
                                });
                                document.getElementById("dropdown-kecamatan").innerHTML = list;

                                attachDropdownEventKecamatan(); // aktifkan click
                            });
                    });
                });

                // Handle Dropdown Kecamatan
                function attachDropdownEventKecamatan() {
                    document.querySelectorAll("#dropdown-kecamatan .dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.getAttribute("data-value");

                            document.getElementById("kecamatan").value = value;
                            document.getElementById("btn-kecamatan").textContent = value;

                            // Reset kelurahan
                            document.getElementById("btn-kelurahan").textContent = "Pilih Kelurahan";
                            document.getElementById("kel_desa").value = "";
                            document.getElementById("dropdown-kelurahan").innerHTML =
                                `<li><span class="dropdown-item-text">Loading...</span></li>`;

                            let kota = document.getElementById("kab_kota").value;

                            fetch(`/get-kelurahan?kota=${kota}&kecamatan=${value}`)
                                .then(res => res.json())
                                .then(data => {
                                    let list = "";
                                    data.forEach(kel => {
                                        list +=
                                            `<li><a class="dropdown-item py-1" data-value="${kel}">${kel}</a></li>`;
                                    });
                                    document.getElementById("dropdown-kelurahan").innerHTML = list;

                                    attachDropdownEventKelurahan();
                                });
                        });
                    });
                }

                // Handle Dropdown Kelurahan
                function attachDropdownEventKelurahan() {
                    document.querySelectorAll("#dropdown-kelurahan .dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.getAttribute("data-value");

                            document.getElementById("kel_desa").value = value;
                            document.getElementById("btn-kelurahan").textContent = value;
                        });
                    });
                }
            </script>

        </div>
    </div>
@endsection
