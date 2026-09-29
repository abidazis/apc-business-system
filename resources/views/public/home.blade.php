@extends('layouts.public')
@section('title', \App\Support\Settings::get('business_short', 'APC') . ' — ' . \App\Support\Settings::get('tagline'))
@section('meta_description', \App\Support\Settings::get('tagline'))

@push('styles')
<style>
/* Homepage Specific Overrides */
.apc-hero-enhanced { min-height: 88vh; }
</style>
@endpush

@section('content')
@php
    $business = \App\Support\Settings::get('business_short', 'APC');
    $tagline = \App\Support\Settings::get('tagline');
    $aboutShort = \App\Support\Settings::get('about_short');
    $heroImg = \App\Support\Settings::get('hero_image');
    $waUrl = \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral());
    $phone = \App\Support\Settings::get('phone');
    $isHomepage = true;
@endphp

{{-- ============================================================
     HERO SECTION — Enhanced Modern Design
     ============================================================ --}}
<section class="apc-hero-enhanced" id="beranda">
    <div class="apc-container">
        <div class="apc-hero-enhanced-grid">
            <div class="apc-hero-enhanced-content">
                <span class="apc-eyebrow apc-eyebrow-dark">
                    <span class="apc-eyebrow-dot"></span> Atribut Paskibra Cikarang
                </span>
                <h1>
                    Perlengkapan Paskibra untuk Tim yang
                    <span class="accent">Siap Tampil Maksimal.</span>
                </h1>
                <p class="apc-hero-enhanced-lead">{{ $aboutShort ?: $tagline }}</p>
                <div class="apc-hero-enhanced-ctas">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="#produk" class="apc-btn apc-btn-outline-light apc-btn-lg">
                        <i class="bi bi-grid-3x3-gap"></i> Lihat Produk
                    </a>
                </div>
                <div class="apc-hero-enhanced-meta">
                    <span><i class="bi bi-check-circle-fill" style="color:var(--apc-yellow);"></i> Konsultasi gratis</span>
                    <span><i class="bi bi-check-circle-fill" style="color:var(--apc-yellow);"></i> Produk customizable</span>
                    <span><i class="bi bi-check-circle-fill" style="color:var(--apc-yellow);"></i>Individu &amp; instansi</span>
                </div>
            </div>
            <div class="apc-hero-enhanced-visual">
                @if($heroImg)
                    <img src="{{ asset('storage/' . $heroImg) }}" alt="{{ $business }} — Perlengkapan Paskibra" loading="eager">
                @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a1a,#2a2a2a);display:flex;align-items:center;justify-content:center;">
                        <div style="text-align:center;">
                            <div style="font-size:72px;margin-bottom:16px;">⚽</div>
                            <div style="color:var(--apc-yellow);font-size:24px;font-weight:900;">APC</div>
                        </div>
                    </div>
                @endif
                <div class="apc-hero-enhanced-badge top">
                    <i class="bi bi-stars"></i>
                    <div>
                        <strong>100+ Proyek</strong>
                        <span style="font-size:11px;display:block;opacity:.7;">Selesai dipercaya</span>
                    </div>
                </div>
                <div class="apc-hero-enhanced-badge bottom">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>Kualitas Terjamin</strong>
                        <span style="font-size:11px;display:block;opacity:.7;">Standar tinggi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     STATS SECTION — Quick Numbers
     ============================================================ --}}
<section class="apc-stats-section">
    <div class="apc-container">
        <div class="apc-stats-grid">
            <div class="apc-stat-item">
                <span class="apc-stat-num">5+</span>
                <span class="apc-stat-label">Tahun Pengalaman</span>
            </div>
            <div class="apc-stat-item">
                <span class="apc-stat-num">100+</span>
                <span class="apc-stat-label">Proyek Selesai</span>
            </div>
            <div class="apc-stat-item">
                <span class="apc-stat-num">50+</span>
                <span class="apc-stat-label">Sekolah Terlayani</span>
            </div>
            <div class="apc-stat-item">
                <span class="apc-stat-num">24/7</span>
                <span class="apc-stat-label">Dukungan Konsultasi</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     TRUST / VALUE PROPS
     ============================================================ --}}
<section class="apc-section apc-section-white" aria-label="Nilai tambah APC">
    <div class="apc-container">
        <div class="apc-trust-grid">
            <div class="apc-trust-item">
                <span class="apc-trust-icon"><i class="bi bi-shield-check"></i></span>
                <div>
                    <strong>Fokus Kebutuhan Paskibra</strong>
                    <span>Spesialis atribut untuk Paskibra sekolah hingga event profesional.</span>
                </div>
            </div>
            <div class="apc-trust-item">
                <span class="apc-trust-icon"><i class="bi bi-chat-dots"></i></span>
                <div>
                    <strong>Bisa Konsultasi Dulu</strong>
                    <span>Diskusikan kebutuhan Anda via WhatsApp sebelum order.</span>
                </div>
            </div>
            <div class="apc-trust-item">
                <span class="apc-trust-icon"><i class="bi bi-building"></i></span>
                <div>
                    <strong>Melayani Pengadaan</strong>
                    <span>Individu maupun instansi/sekolah dalam jumlah besar.</span>
                </div>
            </div>
            <div class="apc-trust-item">
                <span class="apc-trust-icon"><i class="bi bi-palette"></i></span>
                <div>
                    <strong>Produk &amp; Atribut Lengkap</strong>
                    <span>Seragam, atribut, dan perlengkapan Paskibra dalam satu tempat.</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURED PRODUCTS — Enhanced Cards
     ============================================================ --}}
@if($featuredProducts->count())
<section class="apc-section apc-section-soft" id="produk" aria-labelledby="produk-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-section-label"><i class="bi bi-lightning-fill"></i> Produk Unggulan</span>
                <h2 class="apc-section-title-enhanced" id="produk-heading">Pilihan Favorit Paskibra</h2>
                <p class="apc-section-desc">Produk berkualitas tinggi yang sudah dipercaya oleh banyak sekolah dan komunitas.</p>
            </div>
            <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-dark apc-btn-sm">
                Semua Produk <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="apc-scroll-track" role="region" aria-label="Produk carousel" tabindex="0">
            <div class="apc-scroll-inner">
                @foreach($featuredProducts as $product)
                <a href="{{ route('public.products.show', $product->slug) }}" class="apc-product-card-enhanced">
                    <div class="apc-product-card-enhanced-img">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <div class="apc-product-card-enhanced-overlay">
                            <span><i class="bi bi-eye"></i> Lihat Detail</span>
                        </div>
                    </div>
                    <div class="apc-product-card-enhanced-body">
                        @if($product->category)
                            <span class="apc-product-card-enhanced-cat">{{ $product->category->name }}</span>
                        @endif
                        <h3 class="apc-product-card-enhanced-name">{{ $product->name }}</h3>
                        @if($product->price)
                            <span class="apc-product-card-enhanced-price">{{ $product->formatted_price }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="apc-section-foot">
            <a href="{{ route('public.products.index') }}" class="apc-link-arrow">
                Jelajahi Semua Produk <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     CTA BANNER — Mid Page
     ============================================================ --}}
<section class="apc-container">
    <div class="apc-cta-banner">
        <div class="apc-cta-banner-content">
            <h2>Butuh Atribut Paskibra Custom?</h2>
            <p>Konsultasikan kebutuhan spesifik Anda — dari desain, jumlah, hingga deadline. APC siap membantu!</p>
            <div class="apc-cta-banner-btns">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-yellow apc-btn-lg">
                    <i class="bi bi-whatsapp"></i> Mulai Konsultasi
                </a>
                <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-light apc-btn-lg">
                    <i class="bi bi-grid-3x3-gap"></i> Lihat Katalog
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     PRODUCT CATEGORIES
     ============================================================ --}}
@if($categories->count())
<section class="apc-section apc-section-white" id="kategori" aria-labelledby="kategori-heading">
    <div class="apc-container">
        <div class="apc-section-head-center">
            <span class="apc-section-label"><i class="bi bi-tags-fill"></i> Kategori</span>
            <h2 class="apc-section-title-enhanced" id="kategori-heading">Temukan Sesuai Kebutuhan</h2>
            <p class="apc-section-desc" style="margin-inline:auto;">Berbagai kategori atribut Paskibra untuk memenuhi segala kebutuhan Anda.</p>
        </div>
        <div class="apc-cat-scroll-track">
            <div class="apc-cat-scroll-inner">
                @foreach($categories as $cat)
                <a href="{{ route('public.products.index', ['category' => $cat->slug]) }}" class="apc-cat-chip">
                    <span class="apc-cat-chip-name">{{ $cat->name }}</span>
                    <span class="apc-cat-chip-count">{{ $cat->products_count }} produk</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     PORTFOLIO — Social Proof Enhanced
     ============================================================ --}}
@if($portfolios->count())
<section class="apc-section apc-section-soft" id="portfolio" aria-labelledby="portfolio-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-section-label"><i class="bi bi-award-fill"></i> Portfolio</span>
                <h2 class="apc-section-title-enhanced" id="portfolio-heading">Sudah Dipercaya Banyak Sekolah</h2>
                <p class="apc-section-desc">Hasil pekerjaan yang telah diselesaikan dan dipercaya oleh berbagai institusi.</p>
            </div>
            <a href="{{ route('public.portfolio.index') }}" class="apc-btn apc-btn-dark apc-btn-sm">
                Semua Portfolio <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($portfolios as $p)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('public.portfolio.show', $p->slug) }}" class="apc-portfolio-card-enhanced">
                    <div class="apc-portfolio-card-enhanced-img">
                        <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" loading="lazy">
                    </div>
                    <div class="apc-portfolio-card-enhanced-overlay">
                        <div class="apc-portfolio-card-enhanced-body">
                            <h3 class="apc-portfolio-card-enhanced-title">{{ $p->title }}</h3>
                            @if($p->customer_name)
                                <span class="apc-portfolio-card-enhanced-meta">{{ $p->customer_name }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     HOW TO ORDER — Timeline
     ============================================================ --}}
<section class="apc-section apc-section-dark" id="cara-order" aria-labelledby="order-heading">
    <div class="apc-container">
        <div class="apc-section-head-center">
            <span class="apc-eyebrow apc-eyebrow-yellow">Proses</span>
            <h2 class="apc-section-title" style="color:var(--apc-white);" id="order-heading">Cara Order di APC</h2>
            <p class="apc-section-subtitle" style="color:rgba(255,255,255,0.6);">Mudah dan transparan — dari konsultasi hingga pesanan selesai.</p>
        </div>

        <div class="apc-order-timeline">
            <div class="apc-order-step">
                <div class="apc-order-num">01</div>
                <div class="apc-order-card">
                    <span class="apc-order-icon"><i class="bi bi-chat-dots-fill"></i></span>
                    <h3>Konsultasi</h3>
                    <p>Hubungi APC via WhatsApp untuk diskusi kebutuhan Paskibra Anda.</p>
                </div>
            </div>
            <div class="apc-order-connector" aria-hidden="true"></div>
            <div class="apc-order-step">
                <div class="apc-order-num">02</div>
                <div class="apc-order-card">
                    <span class="apc-order-icon"><i class="bi bi-card-checklist"></i></span>
                    <h3>Tentukan Kebutuhan</h3>
                    <p>Pilih produk, jumlah, ukuran, dan customisasi sesuai permintaan.</p>
                </div>
            </div>
            <div class="apc-order-connector" aria-hidden="true"></div>
            <div class="apc-order-step">
                <div class="apc-order-num">03</div>
                <div class="apc-order-card">
                    <span class="apc-order-icon"><i class="bi bi-check2-circle"></i></span>
                    <h3>Konfirmasi Pesanan</h3>
                    <p>Setujui penawaran dan lakukan konfirmasi untuk memasuki fase produksi.</p>
                </div>
            </div>
            <div class="apc-order-connector" aria-hidden="true"></div>
            <div class="apc-order-step">
                <div class="apc-order-num">04</div>
                <div class="apc-order-card">
                    <span class="apc-order-icon"><i class="bi bi-hammer"></i></span>
                    <h3>Produksi</h3>
                    <p>Pesanan dikerjakan sesuai spesifikasi dan standar kualitas APC.</p>
                </div>
            </div>
            <div class="apc-order-connector" aria-hidden="true"></div>
            <div class="apc-order-step">
                <div class="apc-order-num">05</div>
                <div class="apc-order-card">
                    <span class="apc-order-icon"><i class="bi bi-box-seam-fill"></i></span>
                    <h3>Selesai &amp; Dikirim</h3>
                    <p>Pesanan dikemas dan dikirim sesuai jadwal yang sudah disepakati.</p>
                </div>
            </div>
        </div>

        <div class="apc-order-cta">
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Mulai Konsultasi Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     ABOUT PREVIEW
     ============================================================ --}}
<section class="apc-section apc-section-white" id="tentang" aria-labelledby="tentang-heading">
    <div class="apc-container">
        <div class="apc-about-grid">
            <div class="apc-about-content">
                <span class="apc-section-label"><i class="bi bi-building"></i> Tentang APC</span>
                <h2 class="apc-section-title-enhanced" id="tentang-heading">Mitra Tepercaya untuk Kebutuhan Paskibra.</h2>
                <p class="apc-about-body">
                    APC adalah solusi perlengkapan dan atribut Paskibra yang memahami kebutuhan sekolah, komunitas, dan event di seluruh Indonesia. Dengan pengalaman dan fokus pada kualitas, kami membantu tim Paskibra tampil maksimal di setiap kesempatan.
                </p>
                <ul class="apc-about-values">
                    <li>
                        <span class="apc-about-val-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Spesialis atribut Paskibra</span>
                    </li>
                    <li>
                        <span class="apc-about-val-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Customizable sesuai kebutuhan</span>
                    </li>
                    <li>
                        <span class="apc-about-val-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Konsultasi dan penanganan via WhatsApp</span>
                    </li>
                </ul>
                <a href="{{ url('/tentang') }}" class="apc-btn apc-btn-dark mt-4">
                    Kenal APC Lebih Dekat <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="apc-about-visual">
                <div class="apc-about-badge">
                    <span class="apc-about-badge-num">5+</span>
                    <span class="apc-about-badge-label">Tahun Pengalaman</span>
                </div>
                <div class="apc-about-badge apc-about-badge-accent">
                    <span class="apc-about-badge-num">100+</span>
                    <span class="apc-about-badge-label">Proyek Selesai</span>
                </div>
                <div class="apc-about-visual-block" aria-hidden="true">
                    <span class="apc-about-visual-icon"><i class="bi bi-shield-fill-check"></i></span>
                    <p>Kualitas dan kepercayaan adalah prioritas utama kami.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FAQ PREVIEW
     ============================================================ --}}
@if($homepageFaqs->count())
<section class="apc-section apc-section-soft" id="faq" aria-labelledby="faq-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-section-label"><i class="bi bi-question-circle-fill"></i> FAQ</span>
                <h2 class="apc-section-title-enhanced" id="faq-heading">Pertanyaan Umum</h2>
                <p class="apc-section-desc">Jawaban untuk hal yang sering ditanyakan.</p>
            </div>
            <a href="{{ url('/faq') }}" class="apc-btn apc-btn-dark apc-btn-sm">
                FAQ Lengkap <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="apc-faq-list" role="list">
            @foreach($homepageFaqs as $faq)
            <details class="apc-faq-item" role="listitem">
                <summary class="apc-faq-question">
                    <span>{{ $faq->question }}</span>
                    <span class="apc-faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </summary>
                <div class="apc-faq-answer">
                    <p>{{ $faq->answer }}</p>
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     FINAL CTA — Contact Section
     ============================================================ --}}
<section class="apc-section apc-section-final">
    <div class="apc-container">
        <div class="apc-final-cta">
            <div class="apc-final-cta-blob" aria-hidden="true"></div>
            <div class="apc-final-cta-content">
                <h2 class="apc-final-cta-title">Siap Lengkapi Kebutuhan Paskibramu?</h2>
                <p class="apc-final-cta-body">Mulai dari konsultasi gratis — APC bantu kamu dari awal sampai pesanan sampai.</p>
                <div class="apc-final-cta-btns">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-yellow apc-btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
                    </a>
                    <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-light apc-btn-lg">
                        Lihat Produk
                    </a>
                </div>
                @if($phone)
                <p style="margin-top: 20px; font-size: 14px; color: rgba(255,255,255,.6);">
                    Atau hubungi langsung: <strong style="color: var(--apc-yellow);">{{ $phone }}</strong>
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
