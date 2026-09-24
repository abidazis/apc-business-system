@php
    $address = \App\Support\Settings::get('address');
    $phone = \App\Support\Settings::get('phone');
    $email = \App\Support\Settings::get('email');
    $instagram = \App\Support\Settings::get('instagram');
    $tiktok = \App\Support\Settings::get('tiktok');
    $waUrl = \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral());
@endphp
@extends('layouts.public')
@section('title', 'Kontak')

@section('content')
<section class="apc-section-tight">
    <div class="apc-container">
        <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Kontak</span>
        <h1 class="apc-section-title mt-2">Hubungi Kami</h1>
        <p class="apc-section-subtitle" style="margin-left:0;">Respon tercepat melalui WhatsApp atau isi form di bawah.</p>
    </div>
</section>

<div class="apc-container pb-5">
    {{-- Quick Contact Cards --}}
    <div class="row g-3 g-md-4 mb-5">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="apc-stat h-100">
                <div class="apc-stat-label"><i class="bi bi-whatsapp"></i> WhatsApp</div>
                <div class="apc-stat-value" style="font-size: 16px;">Respon cepat</div>
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-sm mt-2">Chat Sekarang</a>
            </div>
        </div>
        @if($phone)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="apc-stat h-100">
                <div class="apc-stat-label"><i class="bi bi-telephone"></i> Telepon</div>
                <div class="apc-stat-value" style="font-size: 16px;">{{ $phone }}</div>
            </div>
        </div>
        @endif
        @if($email)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="apc-stat h-100">
                <div class="apc-stat-label"><i class="bi bi-envelope"></i> Email</div>
                <div class="apc-stat-value" style="font-size: 16px;">{{ $email }}</div>
            </div>
        </div>
        @endif
        @if($instagram || $tiktok)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="apc-stat h-100">
                <div class="apc-stat-label"><i class="bi bi-instagram"></i> Instagram / TikTok</div>
                <div class="apc-stat-value" style="font-size: 16px;">
                    @if($instagram) <a href="https://instagram.com/{{ $instagram }}" target="_blank" rel="noopener">@ {{ $instagram }}</a>@endif
                    @if($instagram && $tiktok) <br>@endif
                    @if($tiktok) <a href="https://tiktok.com/@{{ $tiktok }}" target="_blank" rel="noopener">@ {{ $tiktok }}</a>@endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Contact Form --}}
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="apc-card">
                <div class="p-4">
                    <h2 class="h5 mb-3">Kirim Pesan</h2>
                    <p class="apc-muted mb-4">Isi form di bawah dan kami akan menghubungi Anda via WhatsApp.</p>

                    <form action="{{ route('public.contact.submit') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="apc-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="apc-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="apc-help text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="organization" class="apc-label">Organisasi / Sekolah</label>
                                <input type="text" id="organization" name="organization" class="apc-input @error('organization') is-invalid @enderror" value="{{ old('organization') }}" placeholder="Contoh: SMPN 1 Cikarang">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="apc-label">WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" id="phone" name="phone" class="apc-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="apc-help text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="apc-label">Email</label>
                                <input type="email" id="email" name="email" class="apc-input @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            </div>
                            <div class="col-12">
                                <label for="product_interest" class="apc-label">Produk yang Diminati</label>
                                <input type="text" id="product_interest" name="product_interest" class="apc-input @error('product_interest') is-invalid @enderror" value="{{ old('product_interest') }}" placeholder="Contoh: Atribut Paskibra Full Set">
                            </div>
                            <div class="col-12">
                                <label for="message" class="apc-label">Pesan</label>
                                <textarea id="message" name="message" class="apc-textarea @error('message') is-invalid @enderror" rows="4" placeholder="Ceritakan kebutuhan Anda...">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="apc-btn apc-btn-wa">
                                    <i class="bi bi-whatsapp"></i> Kirim via WhatsApp
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="apc-card apc-card-dark h-100">
                <div class="p-4">
                    <h2 class="h5 mb-3 text-white">Siap konsultasi sekarang?</h2>
                    <p class="text-white-50 mb-4">Tim kami siap membantu kebutuhan atribut Paskibra Anda. Hubungi kami untuk diskusi gratis!</p>
                    <div class="d-flex flex-column gap-3">
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-yellow apc-btn-lg">
                            <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
                        </a>
                        <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-light">
                            <i class="bi bi-grid-3x3-gap"></i> Lihat Katalog Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
