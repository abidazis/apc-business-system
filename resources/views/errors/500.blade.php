@extends('layouts.public')
@section('title', 'Terjadi Kesalahan Server — ' . \App\Support\Settings::get('business_short', 'APC'))

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">500</span>
        <h1 class="apc-section-title mt-3">Terjadi Kesalahan</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Tim kami sudah menerima laporan. Silakan coba beberapa saat lagi.</p>
        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a href="{{ url('/') }}" class="apc-btn apc-btn-primary">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
            <a href="mailto:{{ \App\Support\Settings::get('email') }}" class="apc-btn apc-btn-outline-dark">
                <i class="bi bi-envelope"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection