@extends('layouts.public')
@section('title', 'Halaman Tidak Ditemukan — ' . \App\Support\Settings::get('business_short', 'APC'))
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan.')

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">404</span>
        <h1 class="apc-section-title mt-3">Halaman Tidak Ditemukan</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a href="{{ url('/') }}" class="apc-btn apc-btn-primary">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
            <a href="{{ route('public.products.index') }}" class="apc-btn apc-btn-outline-dark">
                <i class="bi bi-grid-3x3-gap"></i> Lihat Produk
            </a>
        </div>
    </div>
</section>
@endsection