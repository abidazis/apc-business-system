@extends('layouts.public')
@section('title', $project->title)
@section('meta_description', $project->description ?? $project->title)
@section('og_image', $project->cover_image_url)

@section('content')
<div class="apc-section-tight">
    <div class="apc-container">
        <div class="apc-breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('public.portfolio.index') }}">Portfolio</a>
            <span class="sep">/</span>
            <span class="current">{{ $project->title }}</span>
        </div>

        @if($project->customer_name || $project->project_date)
            <div class="apc-mono apc-muted mb-2" style="letter-spacing: 0.08em; text-transform: uppercase;">
                {{ $project->customer_name }}{{ $project->customer_name && $project->project_date ? ' · ' : '' }}{{ $project->project_date ? \App\Services\Formatter::dateId($project->project_date) : '' }}
            </div>
        @endif
        <h1 class="apc-section-title">{{ $project->title }}</h1>

        <div class="mt-4">
            <img src="{{ $project->cover_image_url }}" alt="{{ $project->title }}" style="width: 100%; border-radius: var(--apc-radius-lg); aspect-ratio: 16/9; object-fit: cover;">
        </div>

        @if($project->description)
            <div class="mt-4" style="max-width: 760px; line-height: 1.7;">{!! nl2br(e($project->description)) !!}</div>
        @endif

        @if($project->products->count())
            <div class="mt-5">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 12px;">Produk yang Digunakan</h2>
                <div class="apc-product-grid">
                    @foreach($project->products as $prod)
                        <x-product-card :product="$prod" />
                    @endforeach
                </div>
            </div>
        @endif

        @if($project->images->count())
            <div class="mt-5">
                <h2 style="font-size: 18px; font-weight: 800; margin-bottom: 12px;">Dokumentasi</h2>
                <div class="row g-2 g-md-3">
                    @foreach($project->images as $img)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ $img->image_url }}" target="_blank" rel="noopener">
                                <img src="{{ $img->image_url }}" alt="{{ $img->caption ?? $project->title }}" loading="lazy" style="width: 100%; border-radius: var(--apc-radius); aspect-ratio: 4/3; object-fit: cover;">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-5">
            <div class="apc-cta">
                <h2>Punya proyek serupa?</h2>
                <p>Konsultasikan kebutuhan Anda. Kami bantu dari perencanaan hingga pengiriman.</p>
                <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                    <i class="bi bi-whatsapp"></i> Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection