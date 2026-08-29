@extends('layouts.public')
@section('title', 'Akses Ditolak — ' . \App\Support\Settings::get('business_short', 'APC'))

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">403</span>
        <h1 class="apc-section-title mt-3">Akses Ditolak</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a href="{{ url('/') }}" class="apc-btn apc-btn-primary">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="apc-btn apc-btn-outline-dark">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @endauth
        </div>
    </div>
</section>
@endsection