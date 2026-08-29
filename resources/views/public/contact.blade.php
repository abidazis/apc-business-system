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
        <p class="apc-section-subtitle" style="margin-left:0;">Respon tercepat melalui WhatsApp.</p>
    </div>
</section>

<div class="apc-container pb-5">
    <div class="row g-3 g-md-4">
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

    <div class="mt-5">
        <div class="apc-cta">
            <h2>Siap konsultasi sekarang?</h2>
            <p>Tim kami siap membantu kebutuhan atribut Paskibra Anda.</p>
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection