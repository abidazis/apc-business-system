@extends('layouts.public')
@section('title', 'Sesi Berakhir — ' . \App\Support\Settings::get('business_short', 'APC'))

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">419</span>
        <h1 class="apc-section-title mt-3">Sesi Telah Berakhir</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Untuk keamanan, silakan muat ulang halaman dan coba lagi.</p>
        <a href="{{ url()->previous() }}" class="apc-btn apc-btn-primary mt-4">
            <i class="bi bi-arrow-clockwise"></i> Muat Ulang
        </a>
    </div>
</section>
@endsection