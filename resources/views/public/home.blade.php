@extends('layouts.public')
@section('title', \App\Support\Settings::get('business_short', 'APC') . ' — ' . \App\Support\Settings::get('tagline'))
@section('meta_description', \App\Support\Settings::get('tagline'))

@section('content')
@php
    $business = \App\Support\Settings::get('business_short', 'APC');
    $tagline = \App\Support\Settings::get('tagline');
    $aboutShort = \App\Support\Settings::get('about_short');
    $heroImg = \App\Support\Settings::get('hero_image');
    $waUrl = \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral());
@endphp

{{-- HERO --}}
<section class="apc-hero">
    <div class="apc-container">
        <div class="apc-hero-grid">
            <div>
                <span class="apc-eyebrow"><span style="width:6px;height:6px;border-radius:999px;background:var(--apc-yellow);display:inline-block;"></span> Atribut Paskibra Profesional</span>
                <h1>
                    Perlengkapan Paskibra untuk Tim yang <span class="accent">Siap Tampil Maksimal.</span>
                </h1>
                <p class="lead">{{ $aboutShort ?: $tagline }}</p>
                <div class="apc-hero-ctas">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-light apc-btn-lg">
                        <i class="bi bi-grid-3x3-gap"></i> Lihat Produk
                    </a>
                </div>
                <div class="apc-hero-meta">
                    <span><span class="dot"></span>Konsultasi gratis</span>
                    <span><span class="dot"></span>Produk customizable</span>
                    <span><span class="dot"></span>Untuk individu &amp; instansi</span>
                </div>
            </div>
            <div class="apc-hero-visual">
                @if($heroImg)
                    <img src="{{ asset('storage/' . $heroImg) }}" alt="{{ $business }} — Perlengkapan Paskibra" loading="eager">
                @else
                    <img src="{{ asset('images/hero-default.svg') }}" alt="{{ $business }} — Perlengkapan Paskibra" loading="eager">
                @endif
                <div class="apc-hero-floating top d-none d-md-block">
                    <strong>Konsultasi</strong>
                    Diskusi kebutuhan via WhatsApp
                </div>
                <div class="apc-hero-floating bottom d-none d-md-block">
                    <strong>Siap Kirim</strong>
                    Untuk kebutuhanevent Anda
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featuredProducts->count())
    <section class="apc-section">
        <div class="apc-container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Produk</span>
                    <h2 class="apc-section-title mt-2">Produk Unggulan</h2>
                    <p class="apc-section-subtitle" style="margin-left:0;">Pilihan yang sering menjadi favorit pelanggan.</p>
                </div>
                <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                    Semua Produk <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="apc-product-grid">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- WHY APC --}}
<section class="apc-section" style="background: var(--apc-gray-50);">
    <div class="apc-container">
        <div class="text-center mb-5">
            <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Mengapa APC</span>
            <h2 class="apc-section-title mt-2">Fokus pada kebutuhan Paskibra Anda.</h2>
        </div>
        <div class="apc-value-grid">
            @php
                $why = [
                    ['icon' => 'shield-check', 'title' => 'Spesialis Paskibra', 'desc' => 'Paham seluk-beluk atribut Paskibra dari sekolah hinggaevent profesional.'],
                    ['icon' => 'sliders', 'title' => 'Customizable', 'desc' => 'Ukuran, warna, dan desain mengikuti kebutuhan Anda.'],
                    ['icon' => 'chat-dots', 'title' => 'Konsultasi Langsung', 'desc' => 'Diskusi kebutuhan via WhatsApp sebelum produksi dimulai.'],
                    ['icon' => 'people', 'title' => 'Individu & Instansi', 'desc' => 'Melayani pembelian ecer maupun pengadaan sekolah / Instansi.'],
                ];
            @endphp
            @foreach($why as $w)
                <div class="apc-value">
                    <span class="apc-value-icon"><i class="bi bi-{{ $w['icon'] }}"></i></span>
                    <h3>{{ $w['title'] }}</h3>
                    <p>{{ $w['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PORTFOLIO --}}
@if($portfolios->count())
    <section class="apc-section">
        <div class="apc-container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Portfolio</span>
                    <h2 class="apc-section-title mt-2">Pekerjaan yang telah kami selesaikan.</h2>
                </div>
                <a href="{{ route('public.portfolio.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                    Semua Portfolio <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="apc-portfolio-grid">
                @foreach($portfolios->take(6) as $p)
                    <a href="{{ route('public.portfolio.show', $p->slug) }}" class="apc-portfolio">
                        <div class="apc-portfolio-img">
                            <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" loading="lazy">
                        </div>
                        <div class="apc-portfolio-body">
                            <h4 class="apc-portfolio-title">{{ $p->title }}</h4>
                            @if($p->customer_name || $p->project_date)
                                <p class="apc-portfolio-meta">
                                    {{ $p->customer_name }}{{ $p->customer_name && $p->project_date ? ' · ' : '' }}{{ $p->project_date ? \App\Services\Formatter::dateId($p->project_date) : '' }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- CTA --}}
<section class="apc-section">
    <div class="apc-container">
        <div class="apc-cta">
            <h2>Sedang menyiapkan kebutuhan Paskibra?</h2>
            <p>Diskusikan kebutuhan Anda bersama APC — kami bantu dari konsultasi, produksi, hingga pengiriman.</p>
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
            </a>
        </div>
    </div>
</section>

@endsection