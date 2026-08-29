@extends('layouts.public')
@section('title', 'Produk APC — Atribut Paskibra')
@section('meta_description', 'Katalog atribut Paskibra dari APC. Lihat produk unggulan kami dan konsultasikan kebutuhan Anda via WhatsApp.')

@section('content')
<div class="apc-section-tight">
    <div class="apc-container">
        <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Katalog</span>
        <h1 class="apc-section-title mt-2">Produk APC</h1>
        <p class="apc-section-subtitle" style="margin-left:0;">Atribut Paskibra untuk individu, sekolah, dan Instansi.</p>

        <form method="get" class="mt-4 mb-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute" style="left:16px; top:50%; transform: translateY(-50%); color: var(--apc-text-muted);"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari produk..." style="padding-left:44px;">
            </div>
        </form>

        <div class="apc-chip-row">
            <a href="{{ route('public.products.index') }}" class="apc-chip {{ !request('category') ? 'is-active' : '' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('public.products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" class="apc-chip {{ request('category') === $cat->slug ? 'is-active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        </div>
    </div>
</div>

<div class="apc-container pb-5">
    @if($products->count())
        <div class="apc-product-grid">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-4">{!! $products->links() !!}</div>
    @else
        <div class="apc-empty">
            <i class="bi bi-search"></i>
            <h3>Produk tidak ditemukan</h3>
            <p>Coba kata kunci lain atau hubungi kami untuk kebutuhan khusus.</p>
            <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    @endif
</div>
@endsection