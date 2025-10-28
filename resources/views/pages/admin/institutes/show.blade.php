@extends('layouts.appadmin')

@section('title', 'Detail Institusi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.institutes.index') }}" class="text-decoration-none">Manajemen Institusi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Institusi</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Institusi</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nama Institusi</label>
                <input type="text" class="form-control" value="{{ $institute->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" class="form-control" value="{{ $institute->category }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" class="form-control" value="{{ ucfirst($institute->address) }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" value="{{ $institute->status == 'active' ? 'Aktif' : 'Nonaktif' }}"
                    readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Dibuat pada</label>
                <input type="text" class="form-control"
                    value="{{ $institute->created_at ? $institute->created_at->format('d-m-Y H:i') : '-' }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Terakhir diubah</label>
                <input type="text" class="form-control"
                    value="{{ $institute->updated_at ? $institute->updated_at->format('d-m-Y H:i') : '-' }}" readonly>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.institutes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.institutes.edit', $institute) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
@endsection
