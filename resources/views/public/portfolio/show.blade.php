@extends('layouts.public')
@section('title', $project->title)
@section('meta_description', $project->description ?? $project->title)
@section('og_image', $project->cover_image_url)
@section('content')
<div class="container py-4 py-md-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.portfolio.index') }}">Portfolio</a></li>
            <li class="breadcrumb-item active">{{ $project->title }}</li>
        </ol>
    </nav>

    <h1 class="h2 fw-bold mb-2">{{ $project->title }}</h1>
    @if($project->customer_name || $project->project_date)
        <p class="text-muted">
            @if($project->customer_name){{ $project->customer_name }} @endif
            @if($project->project_date) — {{ \App\Services\Formatter::dateId($project->project_date) }}@endif
        </p>
    @endif

    <img src="{{ $project->cover_image_url }}" alt="{{ $project->title }}" class="img-fluid rounded mb-4">

    @if($project->description)
        <div class="text-muted mb-4">{!! nl2br(e($project->description)) !!}</div>
    @endif

    @if($project->products->count())
        <h5 class="fw-bold">Produk yang Digunakan</h5>
        <ul>
            @foreach($project->products as $prod)
                <li>{{ $prod->name }} @if($prod->pivot->quantity > 1) — {{ $prod->pivot->quantity }} pcs @endif</li>
            @endforeach
        </ul>
    @endif

    @if($project->images->count())
        <h5 class="fw-bold mt-4">Dokumentasi</h5>
        <div class="row g-3">
            @foreach($project->images as $img)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ $img->image_url }}" target="_blank" rel="noopener">
                        <img src="{{ $img->image_url }}" alt="{{ $img->caption }}" class="img-fluid rounded border">
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-5 text-center">
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="btn apc-btn-wa btn-lg">
            <i class="bi bi-whatsapp me-2"></i> Konsultasi Proyek Serupa
        </a>
    </div>
</div>
@endsection