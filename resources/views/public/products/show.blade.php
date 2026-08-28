@extends('layouts.public')
@section('title', $product->name)
@section('meta_description', $product->short_description ?? $product->name)
@section('meta_title', $product->name . ' — ' . \App\Support\Settings::get('business_short'))
@section('og_image', $product->image_url)

@section('content')
<div class="container py-4 py-md-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.products.index') }}">Produk</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('public.products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-lg-5">
        <div class="col-md-6">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded border" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
        </div>
        <div class="col-md-6">
            @if($product->category)
                <span class="badge text-bg-light text-muted mb-2">{{ $product->category->name }}</span>
            @endif
            <h1 class="h2 fw-bold">{{ $product->name }}</h1>
            <p class="text-muted small">SKU: {{ $product->sku }}</p>
            <div class="h4 fw-bold apc-brand-color mb-3">{{ $product->formatted_price }}</div>

            @if($product->short_description)
                <p>{{ $product->short_description }}</p>
            @endif

            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
                    <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                </a>
            </div>

            @if($product->specifications)
                <h6 class="fw-semibold mt-4">Spesifikasi</h6>
                <div class="text-muted">{!! nl2br(e($product->specifications)) !!}</div>
            @endif
        </div>
    </div>

    @if($product->description)
        <div class="mt-5">
            <h5 class="fw-bold">Deskripsi</h5>
            <div class="text-muted">{!! nl2br(e($product->description)) !!}</div>
        </div>
    @endif

    @if($related->count())
        <div class="mt-5">
            <h5 class="fw-bold mb-3">Produk Terkait</h5>
            <div class="row g-4">
                @foreach($related as $p)
                    @include('partials.product-card', ['product' => $p])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection