@extends('layouts.admin')
@section('title', $portfolio->title)
@section('content')
    <x-admin::page-header :title="$portfolio->title" :actions="'<a href=&quot;' . route('admin.portfolio.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a> <a href=&quot;' . route('admin.portfolio.edit', $portfolio) . '&quot; class=&quot;apc-btn apc-btn-primary apc-btn-sm&quot;><i class=&quot;bi bi-pencil&quot;></i> Edit</a>'" />

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="apc-card">
                <div class="card-body p-3 p-md-4">
                    <img src="{{ $portfolio->cover_image_url }}" alt="" style="width: 100%; border-radius: var(--apc-radius); aspect-ratio: 16/9; object-fit: cover;">
                    @if($portfolio->description)<p class="mt-3 mb-0">{!! nl2br(e($portfolio->description)) !!}</p>@endif
                </div>
            </div>
            @if($portfolio->products->count())
                <div class="apc-card mt-3">
                    <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Produk</h2></div>
                    <div class="p-3 p-md-4">
                        <ul class="mb-0">
                            @foreach($portfolio->products as $prod)
                                <li>{{ $prod->name }} @if($prod->pivot->quantity > 1) — {{ $prod->pivot->quantity }} pcs @endif</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="apc-card mt-3">
                <div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--apc-border) !important;">
                    <h2 style="font-size: 14px; font-weight: 700; margin: 0;">Galeri ({{ $portfolio->images->count() }})</h2>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form method="POST" action="{{ route('admin.portfolio.images.upload', $portfolio) }}" enctype="multipart/form-data" class="mb-3 d-flex flex-column flex-md-row gap-2">
                        @csrf
                        <input type="file" name="image" accept="image/*" class="apc-input" required>
                        <input type="text" name="caption" placeholder="Caption (opsional)" class="apc-input">
                        <button class="apc-btn apc-btn-dark apc-btn-sm">Upload</button>
                    </form>
                    <div class="row g-2">
                        @foreach($portfolio->images as $img)
                            <div class="col-6 col-md-3">
                                <div class="position-relative">
                                    <img src="{{ $img->image_url }}" alt="" style="width:100%; border-radius: var(--apc-radius); aspect-ratio: 4/3; object-fit: cover;">
                                    <form method="POST" action="{{ route('admin.portfolio.images.delete', $img) }}" class="position-absolute top-0 end-0 m-1">
                                        @csrf @method('DELETE')
                                        <button class="apc-btn apc-btn-danger apc-btn-sm" style="padding: 4px 8px;"><i class="bi bi-x"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="apc-card">
                <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Info</h2></div>
                <div class="card-body p-3 p-md-4">
                    <p class="mb-2"><strong>Customer:</strong><br>{{ $portfolio->customer_name ?: '-' }}</p>
                    <p class="mb-2"><strong>Tanggal:</strong><br>{{ $portfolio->project_date ? \App\Services\Formatter::dateId($portfolio->project_date) : '-' }}</p>
                    <p class="mb-0"><strong>Status:</strong><br>{{ $portfolio->is_published ? 'Published' : 'Draft' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection