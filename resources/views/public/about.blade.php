@extends('layouts.public')
@section('title', 'Tentang APC')
@section('meta_description', \App\Support\Settings::get('about_short'))
@section('content')
<div class="container py-4 py-md-5">
    <div class="row g-4 g-lg-5 align-items-center">
        <div class="col-lg-6">
            <h1 class="h2 fw-bold mb-3">Tentang APC</h1>
            <p class="text-muted">{{ \App\Support\Settings::get('about_short') }}</p>
            <p class="text-muted">Kami melayani individu, sekolah, dan Instansi yang membutuhkan atribut Paskibra dengan kualitas konsisten dan komunikasi yang jelas.</p>
        </div>
        <div class="col-lg-6">
            <div class="apc-stat mb-3">
                <div class="apc-stat-label">Fokus</div>
                <div class="apc-stat-value">Kualitas & Ketepatan Waktu</div>
            </div>
            <div class="apc-stat mb-3">
                <div class="apc-stat-label">Layanan</div>
                <div class="apc-stat-value">Konsultasi — Produksi — Pengiriman</div>
            </div>
            <div class="apc-stat">
                <div class="apc-stat-label">Wilayah</div>
                <div class="apc-stat-value">{{ \App\Support\Settings::get('address') }}</div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
            <i class="bi bi-whatsapp me-2"></i> Hubungi Kami
        </a>
    </div>
</div>
@endsection