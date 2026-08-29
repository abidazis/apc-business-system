@extends('layouts.admin')
@section('title', $product->name)
@section('content')
    <x-admin::page-header :title="$product->name" :actions="'<a href=&quot;' . route('admin.products.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a> <a href=&quot;' . route('admin.products.edit', $product) . '&quot; class=&quot;apc-btn apc-btn-primary apc-btn-sm&quot;><i class=&quot;bi bi-pencil&quot;></i> Edit</a>'" />

    <div class="apc-card">
        <div class="card-body p-3 p-md-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <img src="{{ $product->image_url }}" alt="" style="width: 100%; aspect-ratio:1/1; object-fit: cover; border-radius: var(--apc-radius); background: var(--apc-gray-100);">
                </div>
                <div class="col-md-8">
                    <table class="apc-table" style="background: transparent;">
                        <tr><th style="width:160px;">Kategori</th><td>{{ $product->category->name ?? '-' }}</td></tr>
                        <tr><th>Harga</th><td>{{ $product->formatted_price }}</td></tr>
                        <tr><th>SKU</th><td><span class="apc-mono">{{ $product->sku }}</span></td></tr>
                        <tr><th>Featured</th><td>{{ $product->is_featured ? 'Ya' : 'Tidak' }}</td></tr>
                        <tr><th>Status</th><td>{{ $product->is_published ? 'Published' : 'Draft' }}</td></tr>
                    </table>
                    @if($product->short_description)
                        <h6 class="fw-bold mt-4">Deskripsi Singkat</h6>
                        <p>{{ $product->short_description }}</p>
                    @endif
                    @if($product->description)
                        <h6 class="fw-bold mt-3">Deskripsi</h6>
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    @endif
                    @if($product->specifications)
                        <h6 class="fw-bold mt-3">Spesifikasi</h6>
                        <p>{!! nl2br(e($product->specifications)) !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection