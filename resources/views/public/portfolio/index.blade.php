@extends('layouts.public')
@section('title', 'Portfolio')
@section('meta_description', 'Portfolio pekerjaan atribut Paskibra APC.')

@section('content')
<div class="apc-section-tight">
    <div class="apc-container">
        <span class="apc-eyebrow" style="background: var(--apc-gray-100);">Portfolio</span>
        <h1 class="apc-section-title mt-2">Pekerjaan Kami</h1>
        <p class="apc-section-subtitle" style="margin-left:0;">Beberapa proyek yang telah kami selesaikan.</p>
    </div>
</div>

<div class="apc-container pb-5">
    @if($portfolios->count())
        <div class="apc-portfolio-grid">
            @foreach($portfolios as $p)
                <a href="{{ route('public.portfolio.show', $p->slug) }}" class="apc-portfolio">
                    <div class="apc-portfolio-img">
                        <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" loading="lazy">
                    </div>
                    <div class="apc-portfolio-body">
                        <h4 class="apc-portfolio-title">{{ $p->title }}</h4>
                        @if($p->customer_name || $p->project_date)
                            <p class="apc-portfolio-meta">
                                {{ $p->customer_name }}{{ $p->customer_name && $p->project_date ? ' · ' : '' }}{{ $p->project_date ? \App\Services\Formatter::dateId($p->project_date) : '' }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4">{!! $portfolios->links() !!}</div>
    @else
        <div class="apc-empty">
            <i class="bi bi-images"></i>
            <h3>Portfolio belum tersedia</h3>
            <p>Portfolio akan segera ditampilkan di sini.</p>
        </div>
    @endif
</div>
@endsection