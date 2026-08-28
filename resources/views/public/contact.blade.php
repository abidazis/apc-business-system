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
<div class="container py-4 py-md-5">
    <h1 class="h2 fw-bold mb-4">Hubungi Kami</h1>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="apc-stat mb-3"><div class="apc-stat-label">Alamat</div><div class="apc-stat-value">{{ $address }}</div></div>
            @if($phone)
                <div class="apc-stat mb-3"><div class="apc-stat-label">Telepon</div><div class="apc-stat-value">{{ $phone }}</div></div>
            @endif
            @if($email)
                <div class="apc-stat mb-3"><div class="apc-stat-label">Email</div><div class="apc-stat-value">{{ $email }}</div></div>
            @endif
            @if($instagram)
                <div class="apc-stat mb-3"><div class="apc-stat-label">Instagram</div><div class="apc-stat-value">@ {{ $instagram }}</div></div>
            @endif
            @if($tiktok)
                <div class="apc-stat mb-3"><div class="apc-stat-label">TikTok</div><div class="apc-stat-value">@ {{ $tiktok }}</div></div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <p class="text-muted">Untuk respon tercepat, hubungi kami melalui WhatsApp.</p>
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
                    <i class="bi bi-whatsapp me-2"></i> Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection