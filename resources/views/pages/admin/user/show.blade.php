@extends('layouts.appadmin')

@section('title', 'Detail User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Manajemen User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail User</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail User</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" value="{{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}"
                    readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Dibuat pada</label>
                <input type="text" class="form-control"
                    value="{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Terakhir diubah</label>
                <input type="text" class="form-control"
                    value="{{ $user->updated_at ? $user->updated_at->format('d-m-Y H:i') : '-' }}" readonly>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
@endsection
