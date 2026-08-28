@extends('layouts.public')
@section('title', 'Portfolio')
@section('meta_description', 'Portfolio proyek atribut Paskibra yang telah dikerjakan APC.')
@section('content')
<div class="container py-4 py-md-5">
    <h1 class="h2 fw-bold mb-4">Portfolio Kami</h1>
    @if($portfolios->count())
        <div class="row g-4">
            @foreach($portfolios as $p)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('public.portfolio.show', $p->slug) }}" class="text-decoration-none text-dark">
                        <div class="apc-card overflow-hidden h-100">
                            <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" class="card-img-top" style="aspect-ratio: 4/3; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">{{ $p->title }}</h6>
                                @if($p->customer_name)
                                    <small class="text-muted">{{ $p->customer_name }}</small>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $portfolios->links() }}</div>
    @else
        <div class="alert alert-info">Belum ada portfolio yang dipublikasikan.</div>
    @endif
</div>
@endsection