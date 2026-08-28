@php
    $faqs = \App\Models\Faq::where('is_published', true)->orderBy('sort_order')->get();
@endphp
@extends('layouts.public')
@section('title', 'FAQ')
@section('content')
<div class="container py-4 py-md-5">
    <h1 class="h2 fw-bold mb-4">Pertanyaan yang Sering Diajukan</h1>
    @if($faqs->count())
        <div class="accordion" id="faqAcc">
            @foreach($faqs as $i => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" data-bs-parent="#faqAcc">
                        <div class="accordion-body">{!! nl2br(e($faq->answer)) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada FAQ yang ditambahkan.</div>
    @endif

    <div class="text-center mt-5">
        <p class="text-muted">Punya pertanyaan lain?</p>
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="btn apc-btn-wa">
            <i class="bi bi-whatsapp me-2"></i> Tanya via WhatsApp
        </a>
    </div>
</div>
@endsection