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
                    <label class="form-label">Nama Gereja <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" placeholder="Masukkan nama gereja" required>

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
                        <x-select-input id="kab_kota" label="Kabupaten/Kota" name="kab_kota" :options="['Surabaya' => 'Surabaya']"
                            placeholder="Pilih Kota" :selected="old('kab_kota')" />
                        @error('kab_kota')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kecamatan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <x-select-input id="kecamatan" label="Kecamatan" name="kecamatan" :options="[]"
                            placeholder="Pilih Kecamatan" :selected="old('kecamatan')" />
                        @error('kecamatan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelurahan --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelurahan / Desa</label>
                        <x-select-input id="kel_desa" label="Kelurahan / Desa" name="kel_desa" :options="[]"
                            placeholder="Pilih Kelurahan" :selected="old('kel_desa')" />
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

                {{-- Nama Pendeta atau Gembala Sidang --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pendeta atau Gembala Sidang</label>
                    <div id="pendeta-wrapper">
                        @php
                            $oldPendetas = old('nama_pendeta', []);
                            if (!is_array($oldPendetas)) {
                                $oldPendetas = $oldPendetas ? [$oldPendetas] : [''];
                            }
                            if (empty($oldPendetas)) {
                                $oldPendetas = [''];
                            }
                        @endphp

                        @foreach ($oldPendetas as $idx => $nama)
                            <div class="mb-2 pendeta-group d-flex gap-2 align-items-center">
                                <input type="text" name="nama_pendeta[]"
                                    class="form-control @error('nama_pendeta.' . $idx) is-invalid @enderror"
                                    value="{{ $nama }}" placeholder="Masukkan nama pendeta atau gembala sidang">
                                <button type="button" class="btn btn-danger remove-pendeta"
                                    {{ $idx === 0 ? 'disabled' : '' }}>
                                    &times;
                                </button>
                                @error('nama_pendeta.' . $idx)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <small class="text-muted mb-2" style="display: block;">Untuk menambah pendeta atau
                        gembala sidang, silakan klik tombol <strong>"Tambah"</strong> di bawah</small>
                    <button type="button" id="add-pendeta" class="btn btn-outline-secondary rounded px-3 py-1">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>

                    @error('nama_pendeta')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Status Gereja</label>

                    <x-select-input id="status_gereja" label="Status Gereja" name="status_gereja" :options="[
                        'permanen' => 'Permanen',
                        'semi-permanen' => 'Semi Permanen',
                        'tidak-permanen' => 'Tidak Permanen',
                    ]"
                        placeholder="Pilih Status" :selected="old('status_gereja')" :searchable="false" />

                    @error('status_gereja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Sertifikat Sekolah Minggu --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Sertifikat Sekolah Minggu (PDF)</label>
                    <input type="file" name="sertifikat_sekolah_minggu_path" class="form-control" accept=".pdf"
                        placeholder="Pilih file PDF">
                    <small class="form-text text-muted">Format: .pdf | Maks: 5MB</small>
                    @error('sertifikat_sekolah_minggu_path')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll("#dropdown-kab_kota .dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.getAttribute("data-value");
                            document.getElementById("kab_kota").value = value;
                            document.getElementById("btn-kab_kota").textContent = value;

                            // Reset kecamatan & kelurahan
                            document.getElementById("btn-kecamatan").textContent = "Pilih Kecamatan";
                            document.getElementById("kecamatan").value = "";
                            document.getElementById("list-kecamatan").innerHTML =
                                `<li><span class="dropdown-item-text">Loading...</span></li>`;

                            document.getElementById("btn-kel_desa").textContent = "Pilih Kelurahan";
                            document.getElementById("kel_desa").value = "";
                            document.getElementById("list-kel_desa").innerHTML =
                                `<li><span class="dropdown-item-text">Pilih kecamatan terlebih dahulu</span></li>`;

                            // Fetch Kecamatan
                            fetch(`/admin/get-kecamatan?kota=${value}`)
                                .then(res => res.json())
                                .then(data => {
                                    let list = "";
                                    data.forEach(kec => {
                                        list +=
                                            `<li><a class="dropdown-item py-1" data-value="${kec}">${kec}</a></li>`;
                                    });
                                    document.getElementById("list-kecamatan").innerHTML = list;
                                    attachDropdownEventKecamatan();
                                });
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
                            document.getElementById("btn-kel_desa").textContent = "Pilih Kelurahan";
                            document.getElementById("kel_desa").value = "";
                            document.getElementById("list-kel_desa").innerHTML =
                                `<li><span class="dropdown-item-text">Loading...</span></li>`;

                            let kota = document.getElementById("kab_kota").value;

                            fetch(`/admin/get-kelurahan?kota=${kota}&kecamatan=${value}`)
                                .then(res => res.json())
                                .then(data => {
                                    let list = "";
                                    data.forEach(kel => {
                                        list +=
                                            `<li><a class="dropdown-item py-1" data-value="${kel}">${kel}</a></li>`;
                                    });
                                    document.getElementById("list-kel_desa").innerHTML = list;
                                    attachDropdownEventKelurahan();
                                });
                        });
                    });
                }

                // Handle Dropdown Kelurahan
                function attachDropdownEventKelurahan() {
                    document.querySelectorAll("#dropdown-kel_desa .dropdown-item").forEach(item => {
                        item.addEventListener("click", function() {
                            const value = this.getAttribute("data-value");
                            document.getElementById("kel_desa").value = value;
                            document.getElementById("btn-kel_desa").textContent = value;
                        });
                    });
                }

                // ============ Multiple Pendeta Input ============
                function clonePendetaGroup() {
                    const wrapper = document.getElementById('pendeta-wrapper');
                    const base = wrapper.querySelector('.pendeta-group');
                    const clone = base.cloneNode(true);

                    // Reset input value
                    const input = clone.querySelector('input[name="nama_pendeta[]"]');
                    if (input) {
                        input.value = '';
                        input.classList.remove('is-invalid');
                    }

                    // Enable remove button
                    const removeBtn = clone.querySelector('.remove-pendeta');
                    if (removeBtn) removeBtn.disabled = false;

                    // Remove error message if exists
                    const errorDiv = clone.querySelector('.invalid-feedback');
                    if (errorDiv) errorDiv.remove();

                    wrapper.appendChild(clone);
                }

                // Bind add button
                document.addEventListener('DOMContentLoaded', function() {
                    const addPendetaBtn = document.getElementById('add-pendeta');
                    if (addPendetaBtn) {
                        addPendetaBtn.addEventListener('click', clonePendetaGroup);
                    }

                    // Delegated remove button
                    document.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-pendeta')) {
                            const groups = document.querySelectorAll('.pendeta-group');
                            if (groups.length > 1) {
                                e.target.closest('.pendeta-group').remove();
                            }
                        }
                    });
                });
            </script>

        </div>
    </div>
@endsection
