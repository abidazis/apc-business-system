@extends('layouts.public', ['hideFloatingWa' => true])
@section('title', $product->name)
@section('meta_description', $product->short_description ?? $product->name)
@section('meta_title', $product->name . ' — ' . \App\Support\Settings::get('business_short'))
@section('og_image', $product->image_url)

@section('content')
<div class="apc-section-tight">
    <div class="apc-container">
        <div class="apc-breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('public.products.index') }}">Produk</a>
            @if($product->category)
                <span class="sep">/</span>
                <a href="{{ route('public.products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            @endif
            <span class="sep">/</span>
            <span class="current">{{ $product->name }}</span>
        </div>

        <div class="row g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <div class="apc-card" style="overflow: hidden;">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="aspect-ratio: 1/1; width: 100%; object-fit: cover;">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                @if($product->category)
                    <span class="apc-eyebrow" style="background: var(--apc-gray-100);">{{ $product->category->name }}</span>
                @endif
                <h1 style="font-size: clamp(26px, 4.5vw, 38px); font-weight: 800; letter-spacing: -0.025em; margin: 12px 0 8px;">{{ $product->name }}</h1>
                <div class="apc-mono apc-muted mb-3">SKU: {{ $product->sku }}</div>
                <div style="font-size: 22px; font-weight: 800; color: var(--apc-ink); margin-bottom: 18px;">{{ $product->formatted_price }}</div>

                @if($product->short_description)
                    <p class="apc-muted" style="font-size: 16px; line-height: 1.6;">{{ $product->short_description }}</p>
                @endif

                <div class="d-flex flex-wrap gap-2 d-none d-lg-flex mb-4">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
                        <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
                    </a>
                    <a href="#spec" class="apc-btn apc-btn-outline-dark apc-btn-lg">
                        Lihat Spesifikasi
                    </a>
                </div>

                @if($product->specifications)
                    <div id="spec" class="mt-4 pt-3">
                        <div class="apc-mono apc-muted" style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 8px;">Spesifikasi</div>
                        <div style="font-size: 14px; line-height: 1.6;">{!! nl2br(e($product->specifications)) !!}</div>
                    </div>
                @endif
            </div>
        </div>

        @if($product->description)
            <div class="mt-5" style="max-width: 760px;">
                <div class="apc-mono apc-muted" style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 8px;">Deskripsi</div>
                <div style="line-height: 1.7;">{!! nl2br(e($product->description)) !!}</div>
            </div>
        @endif

        @if($related->count())
            <div class="mt-5 pt-4">
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 18px;">Produk Terkait</h2>
                <div class="apc-product-grid">
                    @foreach($related as $p)
                        <x-product-card :product="$p" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@php $waProduct = \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageForProduct($product)); @endphp
<div class="apc-sticky-cta">
    <a href="{{ $waProduct }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
        <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
    </a>
</div>
@endsection