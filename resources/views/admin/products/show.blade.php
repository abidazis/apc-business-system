@extends('layouts.admin')
@section('title', 'Detail Produk')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ $product->image_url }}" alt="" class="img-fluid rounded border">
            </div>
            <div class="col-md-8">
                <h4>{{ $product->name }}</h4>
                <p class="text-muted small">SKU: {{ $product->sku }}</p>
                <table class="table table-sm">
                    <tr><th width="160">Kategori</th><td>{{ $product->category->name ?? '-' }}</td></tr>
                    <tr><th>Harga</th><td>{{ $product->formatted_price }}</td></tr>
                    <tr><th>Featured</th><td>{{ $product->is_featured ? 'Ya' : 'Tidak' }}</td></tr>
                    <tr><th>Status</th><td>{{ $product->is_published ? 'Published' : 'Draft' }}</td></tr>
                </table>
                @if($product->short_description)
                    <h6>Deskripsi Singkat</h6>
                    <p>{{ $product->short_description }}</p>
                @endif
                @if($product->description)
                    <h6>Deskripsi</h6>
                    <p>{!! nl2br(e($product->description)) !!}</p>
                @endif
                @if($product->specifications)
                    <h6>Spesifikasi</h6>
                    <p>{!! nl2br(e($product->specifications)) !!}</p>
                @endif
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn apc-brand-bg">Edit</a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection