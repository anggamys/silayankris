@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <x-main-content title="login">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="email">Email</label>
                <input class="w-full border rounded px-3 py-2" type="email" name="email" id="email" required autofocus>
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold" for="password">Password</label>
                <input class="w-full border rounded px-3 py-2" type="password" name="password" id="password" required>
            </div>
            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                type="submit">Login</button>
        </form>
    </x-main-content>
@endsection
