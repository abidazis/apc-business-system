@extends('layouts.auth')
@section('title', 'Login Admin')
@section('content')
<div class="apc-auth-bg">
    <div class="apc-card" style="max-width: 400px; width: 100%; box-shadow: var(--apc-shadow-md); border-radius: var(--apc-radius-xl);">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="apc-brand-mark mx-auto mb-3" style="width:56px; height:56px; font-size:18px;">APC</div>
                <h4 class="fw-bold mb-1" style="letter-spacing:-0.02em;">Admin Login</h4>
                <small class="apc-muted">{{ \App\Support\Settings::get('business_name') }}</small>
            </div>
            @if($errors->any())
                <div class="alert alert-danger small" style="border-radius: var(--apc-radius);">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.attempt') }}">
                @csrf
                <div class="apc-field">
                    <label class="apc-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="apc-input" required autofocus>
                </div>
                <div class="apc-field">
                    <label class="apc-label">Password</label>
                    <input type="password" name="password" class="apc-input" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="apc-btn apc-btn-primary apc-btn-lg apc-btn-block">Masuk</button>
                </div>
            </form>
            <p class="small text-center apc-muted mt-4 mb-0">
                <a href="{{ url('/') }}" class="apc-muted">&larr; Kembali ke website</a>
            </p>
        </div>
    </div>
</div>
@endsection