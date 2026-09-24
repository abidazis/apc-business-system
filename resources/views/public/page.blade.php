@extends('layouts.public')
@section('title', $page->title)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($page->content), 160))

@section('content')
<section class="apc-section-tight">
    <div class="apc-container">
        <span class="apc-eyebrow" style="background: var(--apc-gray-100);">{{ $page->title }}</span>
        <h1 class="apc-section-title mt-2">{{ $page->title }}</h1>
    </div>
</section>

<div class="apc-container pb-5">
    <div class="apc-card">
        <div class="p-4 p-md-5">
            <div class="apc-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="mt-5">
        <div class="apc-cta">
            <h2>Siap konsultasi sekarang?</h2>
            <p>Tim kami siap membantu kebutuhan atribut Paskibra Anda.</p>
            <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
