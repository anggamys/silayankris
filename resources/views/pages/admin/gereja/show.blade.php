@extends('layouts.appadmin')

@section('title', 'Detail Gereja')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.gereja.index') }}" class="text-decoration-none">Data Gereja</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Gereja</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Gereja</h5>

            <a href="{{ route('admin.gereja.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- Nama Gereja --}}
            <div class="mb-3">
                <label class="form-label">Nama Gereja</label>
                <input type="text" class="form-control" value="{{ $gereja->nama }}" readonly>
            </div>

            {{-- Tanggal Berdiri --}}
            <div class="mb-3">
                <label class="form-label">Tanggal Berdiri</label>
                <input type="date" class="form-control"
                    value="{{ optional($gereja->tanggal_berdiri)->format('Y-m-d') }}" readonly>
            </div>

            {{-- Tanggal Bergabung --}}
            <div class="mb-3">
                <label class="form-label">Tanggal Bergabung Sinode</label>
                <input type="date" class="form-control"
                    value="{{ optional($gereja->tanggal_bergabung_sinode)->format('Y-m-d') }}" readonly>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" class="form-control" value="{{ $gereja->alamat }}" readonly>
            </div>

            <div class="row">
                {{-- Kota --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kabupaten/Kota</label>
                    <input type="text" class="form-control" value="{{ $gereja->kab_kota }}" readonly>
                </div>

                {{-- Kecamatan --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" class="form-control" value="{{ $gereja->kecamatan }}" readonly>
                </div>

                {{-- Kelurahan --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kelurahan / Desa</label>
                    <input type="text" class="form-control" value="{{ $gereja->kel_desa }}" readonly>
                </div>
            </div>

            {{-- Jarak --}}
            <div class="mb-3">
                <label class="form-label">Jarak Gereja Lain</label>
                <input type="text" class="form-control" value="{{ $gereja->jarak_gereja_lain }}" readonly>
            </div>

            {{-- Kontak --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $gereja->email }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" value="{{ $gereja->nomor_telepon }}" readonly>
                </div>
            </div>

            {{-- Nama Pendeta --}}
            <div class="mb-3">
                <label class="form-label">Nama Pendeta</label>
                <input type="text" class="form-control" value="{{ $gereja->nama_pendeta }}" readonly>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status Gereja</label>
                <input type="text" class="form-control" value="{{ ucfirst($gereja->status_gereja) }}" readonly>
            </div>

            <h5 class="mt-4 fw-bold">Data Jemaat</h5>

            <div class="row">
                {{-- Jumlah Umat --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Umat</label>
                    <input type="text" class="form-control mb-2"
                        value="Laki-laki: {{ $gereja->jumlah_umat['laki_laki'] ?? 0 }}" readonly>
                    <input type="text" class="form-control"
                        value="Perempuan: {{ $gereja->jumlah_umat['perempuan'] ?? 0 }}" readonly>
                </div>

                {{-- Jumlah Majelis --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Majelis</label>
                    <input type="text" class="form-control mb-2"
                        value="Laki-laki: {{ $gereja->jumlah_majelis['laki_laki'] ?? 0 }}" readonly>
                    <input type="text" class="form-control"
                        value="Perempuan: {{ $gereja->jumlah_majelis['perempuan'] ?? 0 }}" readonly>
                </div>

                {{-- Jumlah Pemuda --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Pemuda</label>
                    <input type="text" class="form-control mb-2"
                        value="Laki-laki: {{ $gereja->jumlah_pemuda['laki_laki'] ?? 0 }}" readonly>
                    <input type="text" class="form-control"
                        value="Perempuan: {{ $gereja->jumlah_pemuda['perempuan'] ?? 0 }}" readonly>
                </div>

                {{-- Jumlah Guru Sekolah Minggu --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Guru Sekolah Minggu</label>
                    <input type="text" class="form-control mb-2"
                        value="Laki-laki: {{ $gereja->jumlah_guru_sekolah_minggu['laki_laki'] ?? 0 }}" readonly>
                    <input type="text" class="form-control"
                        value="Perempuan: {{ $gereja->jumlah_guru_sekolah_minggu['perempuan'] ?? 0 }}" readonly>
                </div>

                {{-- Jumlah Murid Sekolah Minggu --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Murid Sekolah Minggu</label>
                    <input type="text" class="form-control mb-2"
                        value="Laki-laki: {{ $gereja->jumlah_murid_sekolah_minggu['laki_laki'] ?? 0 }}" readonly>
                    <input type="text" class="form-control"
                        value="Perempuan: {{ $gereja->jumlah_murid_sekolah_minggu['perempuan'] ?? 0 }}" readonly>
                </div>
            </div>

        </div>
    </div>
@endsection
