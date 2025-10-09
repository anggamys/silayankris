@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Statistik 1</h5>
                    <p class="card-text">Isi statistik atau info singkat di sini.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Statistik 2</h5>
                    <p class="card-text">Isi statistik atau info singkat di sini.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Statistik 3</h5>
                    <p class="card-text">Isi statistik atau info singkat di sini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
