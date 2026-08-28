@php
    $businessName = \App\Support\Settings::get('business_name', 'APC');
    $businessShort = \App\Support\Settings::get('business_short', 'APC');
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="{{ $businessShort }}" height="32">
            <span class="fw-bold">{{ $businessShort }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#apcNav" aria-controls="apcNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="apcNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.products.index') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('public.portfolio.index') }}">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/tentang') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/faq') }}">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/kontak') }}">Kontak</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn apc-btn-wa btn-sm" target="_blank" rel="noopener" href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
