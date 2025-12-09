@extends('layouts.app')

@section('title', 'Login - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Welcome Back!</h1>
            <p>Login to your KICKSup account</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <small style="color: var(--red); font-size: 0.85rem;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-size: 1rem; margin-top: 0.5rem;">
                Login
            </button>
        </form>

        <div class="auth-link">
            Don't have an account? 
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</div>
@endsection