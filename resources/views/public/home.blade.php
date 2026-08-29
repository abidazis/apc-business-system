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
    $isHomepage = true;
@endphp

{{-- ============================================================
     SECTION 1 — HERO
     ============================================================ --}}
<section class="apc-hero" id="beranda">
    <div class="apc-container">
        <div class="apc-hero-grid">
            <div class="apc-hero-content">
                <span class="apc-eyebrow apc-eyebrow-dark">
                    <span class="apc-eyebrow-dot"></span> Atribut Paskibra Cikarang
                </span>
                <h1>
                    Perlengkapan Paskibra untuk Tim yang
                    <span class="apc-hero-accent">Siap Tampil Maksimal.</span>
                </h1>
                <p class="apc-hero-lead">{{ $aboutShort ?: $tagline }}</p>
                <div class="apc-hero-ctas">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="#produk" class="apc-btn apc-btn-outline-light apc-btn-lg">
                        <i class="bi bi-grid-3x3-gap"></i> Lihat Produk
                    </a>
                </div>
                <div class="apc-hero-meta">
                    <span><span class="apc-dot"></span>Konsultasi gratis</span>
                    <span><span class="apc-dot"></span>Produk customizable</span>
                    <span><span class="apc-dot"></span>Individu &amp; instansi</span>
                </div>
            </div>
            <div class="apc-hero-visual">
                @if($heroImg)
                    <img src="{{ asset('storage/' . $heroImg) }}" alt="{{ $business }} — Perlengkapan Paskibra" loading="eager">
                @else
                    <div class="apc-hero-placeholder">
                        <svg viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect width="400" height="400" rx="24" fill="#1a1a1a"/>
                            <path d="M200 80 L260 160 L200 200 L140 160 Z" fill="#FFC600" opacity="0.9"/>
                            <path d="M200 200 L260 160 L300 200 L200 280 L100 200 L140 160 Z" fill="#FFC600" opacity="0.6"/>
                            <circle cx="200" cy="310" r="40" fill="#FFC600" opacity="0.3"/>
                            <text x="200" y="318" text-anchor="middle" font-size="14" font-weight="700" fill="#FFC600" font-family="Inter, sans-serif">APC</text>
                        </svg>
                    </div>
                @endif
                <div class="apc-hero-float apc-hero-float-top d-none d-md-block">
                    <span class="apc-hero-float-icon"><i class="bi bi-chat-dots-fill"></i></span>
                    <div>
                        <strong>Konsultasi</strong>
                        <span>Diskusi via WhatsApp</span>
                    </div>
                </div>
                <div class="apc-hero-float apc-hero-float-bottom d-none d-md-block">
                    <span class="apc-hero-float-icon apc-hero-float-icon-yellow"><i class="bi bi-box-seam-fill"></i></span>
                    <div>
                        <strong>Siap Kirim</strong>
                        <span>Untuk event Anda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 2 — QUICK TRUST / VALUE PROPS
     ============================================================ --}}
<section class="apc-trust" aria-label="Nilai tambah APC">
    <div class="apc-container">
        <div class="apc-trust-grid">
            <div class="apc-trust-item">
                <span class="apc-trust-icon"><i class="bi bi-shield-check"></i></span>
                <div>
                    <strong>Fokus Kebutuhan Paskibra</strong>
                    <span>Spesialis atribut untuk Paskibra sekolah hinggaevent profesional.</span>
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
     SECTION 3 — FEATURED PRODUCTS
     ============================================================ --}}
@if($featuredProducts->count())
<section class="apc-section apc-section-white" id="produk" aria-labelledby="produk-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-eyebrow">Produk</span>
                <h2 class="apc-section-title mt-2" id="produk-heading">Produk Unggulan</h2>
                <p class="apc-section-subtitle" style="margin-left:0;">Pilihan favorit pelanggan Paskibra.</p>
            </div>
            <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                Semua Produk <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="apc-scroll-track" role="region" aria-label="Produk carousel" tabindex="0">
            <div class="apc-scroll-inner">
                @foreach($featuredProducts as $product)
                <a href="{{ route('public.products.show', $product->slug) }}" class="apc-product-card">
                    <div class="apc-product-card-img">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                    <div class="apc-product-card-body">
                        @if($product->category)
                            <span class="apc-product-card-cat">{{ $product->category->name }}</span>
                        @endif
                        <h3 class="apc-product-card-name">{{ $product->name }}</h3>
                        @if($product->price)
                            <span class="apc-product-card-price">{{ $product->formatted_price }}</span>
                        @endif
                        <span class="apc-product-card-cta"><i class="bi bi-arrow-right"></i></span>
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
     SECTION 4 — PRODUCT CATEGORIES
     ============================================================ --}}
@if($categories->count())
<section class="apc-section apc-section-soft" id="kategori" aria-labelledby="kategori-heading">
    <div class="apc-container">
        <div class="apc-section-head-center">
            <span class="apc-eyebrow">Kategori</span>
            <h2 class="apc-section-title mt-2" id="kategori-heading">Temukan sesuai kebutuhan</h2>
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
     SECTION 5 — PORTFOLIO / SOCIAL PROOF
     ============================================================ --}}
@if($portfolios->count())
<section class="apc-section apc-section-white" id="portfolio" aria-labelledby="portfolio-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-eyebrow">Portfolio</span>
                <h2 class="apc-section-title mt-2" id="portfolio-heading">Sudah Dipercaya untuk Kebutuhan Paskibra</h2>
                <p class="apc-section-subtitle" style="margin-left:0;">Beberapa pekerjaan yang telah kami selesaikan.</p>
            </div>
            <a href="{{ route('public.portfolio.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                Semua Portfolio <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="apc-scroll-track" role="region" aria-label="Portfolio carousel" tabindex="0">
            <div class="apc-scroll-inner">
                @foreach($portfolios as $p)
                <a href="{{ route('public.portfolio.show', $p->slug) }}" class="apc-portfolio-card">
                    <div class="apc-portfolio-card-img">
                        <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" loading="lazy">
                        <div class="apc-portfolio-card-overlay">
                            <span class="apc-portfolio-card-view"><i class="bi bi-eye"></i> Lihat</span>
                        </div>
                    </div>
                    <div class="apc-portfolio-card-body">
                        <h3 class="apc-portfolio-card-name">{{ $p->title }}</h3>
                        @if($p->customer_name)
                            <span class="apc-portfolio-card-meta">{{ $p->customer_name }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     SECTION 6 — HOW TO ORDER / CARA ORDER
     ============================================================ --}}
<section class="apc-section apc-section-dark" id="cara-order" aria-labelledby="order-heading">
    <div class="apc-container">
        <div class="apc-section-head-center">
            <span class="apc-eyebrow apc-eyebrow-yellow">Proses</span>
            <h2 class="apc-section-title mt-2" id="order-heading">Cara Order di APC</h2>
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
     SECTION 7 — ABOUT PREVIEW
     ============================================================ --}}
<section class="apc-section apc-section-white" id="tentang" aria-labelledby="tentang-heading">
    <div class="apc-container">
        <div class="apc-about-grid">
            <div class="apc-about-content">
                <span class="apc-eyebrow">Tentang APC</span>
                <h2 class="apc-section-title mt-2" id="tentang-heading"> Mitra Tepercaya untuk Kebutuhan Paskibra.</h2>
                <p class="apc-about-body">
                    APC adalah solusi perlengkapan dan atribut Paskibra yang memahami kebutuhan sekolah, komunitas, danevent di seluruh Indonesia. Dengan pengalaman dan fokus pada kualitas, kami membantu tim Paskibra tampil maksimal di setiap kesempatan.
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
     SECTION 8 — FAQ PREVIEW
     ============================================================ --}}
@if($homepageFaqs->count())
<section class="apc-section apc-section-soft" id="faq" aria-labelledby="faq-heading">
    <div class="apc-container">
        <div class="apc-section-head">
            <div>
                <span class="apc-eyebrow">FAQ</span>
                <h2 class="apc-section-title mt-2" id="faq-heading">Pertanyaan Umum</h2>
                <p class="apc-section-subtitle" style="margin-left:0;">Jawaban untuk hal yang sering ditanyakan.</p>
            </div>
            <a href="{{ url('/faq') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
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
     SECTION 9 — CONTEXTUAL MID CTA
     ============================================================ --}}
<section class="apc-section apc-section-tight apc-section-white">
    <div class="apc-container">
        <div class="apc-mid-cta">
            <div class="apc-mid-cta-content">
                <span class="apc-eyebrow apc-eyebrow-yellow">Butuh Bantuan?</span>
                <h2 class="apc-mid-cta-title">Sudah tahu kebutuhanmu?</h2>
                <p class="apc-mid-cta-body">Kalau masih bingung, konsultasikan langsung dengan APC — gratis dan tanpa komitmen.</p>
            </div>
            <div class="apc-mid-cta-action">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
                    <i class="bi bi-whatsapp"></i> Chat WhatsApp
                </a>
                <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-ghost apc-btn-lg">
                    Lihat Produk <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 10 — FINAL CTA
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
            </div>
        </div>
    </div>
</section>

@endsection
