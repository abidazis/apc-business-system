@extends('layouts.public')
@section('title', 'Tentang APC')
@section('meta_description', \App\Support\Settings::get('about_short'))

@section('content')
<section class="apc-hero" style="padding-block: 64px;">
    <div class="apc-container">
        <div class="apc-hero-grid">
            <div>
                <span class="apc-eyebrow"><span style="width:6px;height:6px;border-radius:999px;background:var(--apc-yellow);display:inline-block;"></span> Tentang APC</span>
                <h1>Spesialis atribut Paskibra untuk kebutuhan Anda.</h1>
                <p class="lead">{{ \App\Support\Settings::get('about_short') }}</p>
            </div>
            <div class="apc-hero-visual">
                <img src="{{ asset('images/hero-default.svg') }}" alt="APC">
            </div>
        </div>
    </div>
</section>

<section class="apc-section">
    <div class="apc-container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-6">
                <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Apa yang kami lakukan</span>
                <h2 class="apc-section-title mt-2">Dari konsultasi hingga pengiriman.</h2>
                <p class="apc-muted mt-3" style="line-height: 1.7;">Kami melayani individu, sekolah, dan Instansi yang membutuhkan atribut Paskibra dengan kualitas konsisten, ketepatan waktu, dan komunikasi yang jelas.</p>
                <ul class="list-unstyled mt-4" style="line-height: 2;">
                    <li><i class="bi bi-check2-circle text-yellow me-2"></i> Konsultasi kebutuhan via WhatsApp</li>
                    <li><i class="bi bi-check2-circle text-yellow me-2"></i> Produk dapat disesuaikan</li>
                    <li><i class="bi bi-check2-circle text-yellow me-2"></i> Produksi dengan QC</li>
                    <li><i class="bi bi-check2-circle text-yellow me-2"></i> Pengiriman tepat waktu</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6"><div class="apc-stat apc-stat-dark"><div class="apc-stat-label">Fokus</div><div class="apc-stat-value">Kualitas</div></div></div>
                    <div class="col-6"><div class="apc-stat apc-stat-accent"><div class="apc-stat-label">Komitmen</div><div class="apc-stat-value">Tepat Waktu</div></div></div>
                    <div class="col-6"><div class="apc-stat"><div class="apc-stat-label">Layanan</div><div class="apc-stat-value">Konsultasi</div></div></div>
                    <div class="col-6"><div class="apc-stat"><div class="apc-stat-label">Wilayah</div><div class="apc-stat-value">Indonesia</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apc-section" style="background: var(--apc-gray-50);">
    <div class="apc-container">
        <div class="apc-cta">
            <h2>Diskusikan kebutuhan Anda sekarang.</h2>
            <p>Kami siap membantu dari konsultasi, desain, produksi, hingga pengiriman.</p>
            <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection