@extends('layouts.public')
@section('title', 'Produk')
@section('meta_description', 'Daftar produk atribut Paskibra dari APC.')
@section('content')

<div class="container py-4 py-md-5">
    <h1 class="h2 fw-bold mb-4">Produk APC</h1>
    <div class="row g-4">
        <aside class="col-lg-3">
            <form method="get" class="mb-3">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari produk...">
            </form>
            <h6 class="text-uppercase small fw-semibold text-muted">Kategori</h6>
            <div class="list-group">
                <a href="{{ route('public.products.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('public.products.index', ['category' => $cat->slug]) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between {{ request('category') === $cat->slug ? 'active' : '' }}">
                        <span>{{ $cat->name }}</span>
                        <span class="badge text-bg-light">{{ $cat->products_count }}</span>
                    </a>
                @endforeach
            </div>
        </aside>
        <div class="col-lg-9">
            @if($products->count())
                <div class="row g-4">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-4">{{ $products->links() }}</div>
            @else
                <div class="alert alert-info">Belum ada produk untuk kriteria ini.</div>
            @endif
        </div>
    </div>
</div>
@endsection