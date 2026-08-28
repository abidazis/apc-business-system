@extends('layouts.public')
@section('title', \App\Support\Settings::get('business_short') . ' — ' . \App\Support\Settings::get('tagline'))
@section('meta_description', \App\Support\Settings::get('tagline'))
@section('content')

@php
    $business = \App\Support\Settings::get('business_short', 'APC');
    $heroImg = \App\Support\Settings::get('hero_image');
    $waUrl = \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral());
@endphp

{{-- HERO --}}
<section class="apc-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-light text-dark mb-3 fw-semibold">Atribut Paskibra Profesional</span>
                <h1 class="display-5 fw-bold mb-3">{{ \App\Support\Settings::get('tagline') }}</h1>
                <p class="lead text-light-emphasis mb-4">
                    {{ \App\Support\Settings::get('about_short') }}
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
                        <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                    </a>
                    <a href="{{ route('public.products.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-grid me-2"></i> Lihat Produk
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <img src="{{ $heroImg ? asset('storage/' . $heroImg) : asset('images/hero-default.svg') }}" alt="APC" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

{{-- PRODUCT HIGHLIGHTS --}}
@if($featuredProducts->count())
<section class="apc-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Produk Unggulan</h2>
            <p class="text-muted">Beberapa produk yang sering menjadi pilihan pelanggan kami.</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('public.products.index') }}" class="btn apc-brand-bg">
                Lihat Semua Produk <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- PORTFOLIO --}}
@if($portfolios->count())
<section class="apc-section bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Portfolio Kami</h2>
            <p class="text-muted">Beberapa proyek yang telah kami kerjakan.</p>
        </div>
        <div class="row g-4">
            @foreach($portfolios as $p)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('public.portfolio.show', $p->slug) }}" class="text-decoration-none text-dark">
                        <div class="apc-card overflow-hidden h-100">
                            <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" class="card-img-top" style="aspect-ratio: 4/3; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">{{ $p->title }}</h6>
                                @if($p->customer_name)
                                    <small class="text-muted">{{ $p->customer_name }}</small>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('public.portfolio.index') }}" class="btn btn-outline-dark">Lihat Semua Portfolio</a>
        </div>
    </div>
</section>
@endif

{{-- WHY APC --}}
<section class="apc-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <h2 class="fw-bold mb-3">Mengapa APC?</h2>
                <p class="text-muted">Fokus kami adalah kualitas atribut, ketepatan waktu, dan komunikasi yang jelas dengan setiap pelanggan.</p>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    @php
                        $why = [
                            ['icon' => 'shield-check', 'title' => 'Pengalaman Paskibra', 'desc' => 'Memahami kebutuhan atribut Paskibra dari tingkat sekolah hinggaevent profesional.'],
                            ['icon' => 'sliders', 'title' => 'Produk Dapat Disesuaikan', 'desc' => 'Ukuran, warna, dan desain dapat disesuaikan dengan kebutuhan Anda.'],
                            ['icon' => 'chat-dots', 'title' => 'Konsultasi Langsung', 'desc' => 'Diskusi kebutuhan via WhatsApp sebelum produksi dimulai.'],
                            ['icon' => 'people', 'title' => 'Individu & Pengadaan', 'desc' => 'Melayani pembelian individu maupun pengadaan Instansi / Sekolah.'],
                            ['icon' => 'images', 'title' => 'Dokumentasi Nyata', 'desc' => 'Pekerjaan terdokumentasi di halaman portfolio kami.'],
                        ];
                    @endphp
                    @foreach($why as $w)
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <i class="bi bi-{{ $w['icon'] }} fs-3 text-apc-red"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $w['title'] }}</h6>
                                    <p class="small text-muted mb-0">{{ $w['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="apc-section bg-dark text-light text-center">
    <div class="container">
        <h2 class="fw-bold mb-2">Sedang menyiapkan kebutuhan Paskibra?</h2>
        <p class="text-light-emphasis mb-4">Diskusikan kebutuhan Anda bersama APC — kami bantu dari konsultasi hingga pengiriman.</p>
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
            <i class="bi bi-whatsapp me-2"></i> Chat WhatsApp
        </a>
    </div>
</section>

@endsection