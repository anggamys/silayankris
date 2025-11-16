@extends('layouts.appadmin')

@section('title', 'Tambah Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">Data Gereja</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Gereja</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Tambah Gereja</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.gereja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Nama Gereja</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" placeholder="Masukkan nama gereja" >

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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kel/Desa</label>
                        <input type="text" name="kel_desa" class="form-control @error('kel_desa') is-invalid @enderror"
                            value="{{ old('kel_desa') }}" placeholder="Kelurahan / Desa">

                        @error('kel_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror"
                            value="{{ old('kecamatan') }}" placeholder="Masukkan kecamatan">

                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kab/Kota</label>
                        <input type="text" name="kab_kota" class="form-control @error('kab_kota') is-invalid @enderror"
                            value="{{ old('kab_kota') }}" placeholder="Kabupaten / Kota">

                        @error('kab_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
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
                        class="form-control @error('nama_pendeta') is-invalid @enderror" value="{{ old('nama_pendeta') }}"
                        placeholder="Masukkan nama pendeta">

                    @error('nama_pendeta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Kontak --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                            placeholder="Masukkan email gereja">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control"
                            value="{{ old('nomor_telepon') }}" placeholder="Masukkan nomor telepon">
                    </div>
                </div>

                {{-- Nama Pendeta --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pendeta</label>
                    <input type="text" name="nama_pendeta" class="form-control" value="{{ old('nama_pendeta') }}"
                        placeholder="Masukkan nama pendeta">
                </div>


                {{-- Status Gereja --}}
                <div class="mb-3">
                    <label class="form-label">Status Gereja</label>
                    <select name="status_gereja" class="form-select @error('status_gereja') is-invalid @enderror">
                        <option value="">Pilih Status</option>
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
                                placeholder="Jumlah laki-laki" value="{{ old('jumlah_umat.laki_laki', 0) }}"  min="0">
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
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.gereja.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
            </form>
        </div>
    </div>
@endsection
