@extends('layouts.auth')
@section('title', 'Login Admin')
@section('content')
<div class="apc-auth-bg">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.svg') }}" alt="APC" height="48" class="mb-2">
                <h4 class="fw-bold mb-0">Admin Login</h4>
                <small class="text-muted">{{ \App\Support\Settings::get('business_name') }}</small>
            </div>
            @if($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.attempt') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn apc-brand-bg">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection