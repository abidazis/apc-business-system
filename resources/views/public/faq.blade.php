@php
    $faqs = \App\Models\Faq::where('is_published', true)->orderBy('sort_order')->get();
@endphp
@extends('layouts.public')
@section('title', 'FAQ')
@section('meta_description', 'Pertanyaan yang sering diajukan tentang APC dan produk atribut Paskibra.')

@section('content')
<section class="apc-section-tight">
    <div class="apc-container">
        <span class="apc-eyebrow" style="background: var(--apc-gray-100);">FAQ</span>
        <h1 class="apc-section-title mt-2">Pertanyaan yang sering diajukan</h1>
        <p class="apc-section-subtitle" style="margin-left:0;">Belum menemukan jawabannya? Langsung tanya via WhatsApp.</p>
    </div>
</section>

<div class="apc-container pb-5">
    @if($faqs->count())
        <div class="apc-table-wrap" style="border: 0;">
            <div class="accordion accordion-flush" id="faqAcc">
                @foreach($faqs as $i => $faq)
                    <div class="accordion-item" style="border-color: var(--apc-border);">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}" style="font-weight: 600; font-size: 16px;">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" data-bs-parent="#faqAcc">
                            <div class="accordion-body apc-muted" style="line-height: 1.7;">{!! nl2br(e($faq->answer)) !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="apc-empty">
            <i class="bi bi-question-circle"></i>
            <h3>Belum ada FAQ</h3>
            <p>Silakan langsung bertanya via WhatsApp.</p>
        </div>
    @endif

    <div class="text-center mt-5">
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-lg">
            <i class="bi bi-whatsapp"></i> Tanya via WhatsApp
        </a>
    </div>
</div>
@endsection