@extends('layouts.admin')
@section('title', 'Detail Portfolio')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">{{ $portfolio->title }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.portfolio.edit', $portfolio) }}" class="btn btn-sm apc-brand-bg">Edit</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <img src="{{ $portfolio->cover_image_url }}" alt="" class="img-fluid rounded mb-3">
        @if($portfolio->description)
            <p>{!! nl2br(e($portfolio->description)) !!}</p>
        @endif
        @if($portfolio->products->count())
            <h6>Produk</h6>
            <ul>
                @foreach($portfolio->products as $prod)
                    <li>{{ $prod->name }} @if($prod->pivot->quantity > 1) — {{ $prod->pivot->quantity }} pcs @endif</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-white"><h6 class="fw-bold mb-0">Info</h6></div>
            <div class="card-body small">
                <p>Customer: {{ $portfolio->customer_name ?: '-' }}</p>
                <p>Tanggal: {{ $portfolio->project_date ? \App\Services\Formatter::dateId($portfolio->project_date) : '-' }}</p>
                <p>Status: {{ $portfolio->is_published ? 'Published' : 'Draft' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">Galeri ({{ $portfolio->images->count() }})</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.portfolio.images.upload', $portfolio) }}" enctype="multipart/form-data" class="mb-3 d-flex gap-2">
            @csrf
            <input type="file" name="image" accept="image/*" class="form-control" required>
            <input type="text" name="caption" placeholder="Caption (opsional)" class="form-control">
            <button class="btn apc-brand-bg">Upload</button>
        </form>
        <div class="row g-2">
            @foreach($portfolio->images as $img)
                <div class="col-md-3">
                    <div class="position-relative">
                        <img src="{{ $img->image_url }}" alt="" class="img-fluid rounded border">
                        <form method="POST" action="{{ route('admin.portfolio.images.delete', $img) }}" class="position-absolute top-0 end-0 m-1">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection