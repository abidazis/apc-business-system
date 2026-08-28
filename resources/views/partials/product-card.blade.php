@props(['product'])
<div class="col-md-6 col-lg-4">
    <div class="apc-card h-100 overflow-hidden">
        <a href="{{ route('public.products.show', $product->slug) }}" class="text-decoration-none text-dark">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-img-top" style="aspect-ratio: 4/3; object-fit: cover;">
            <div class="card-body">
                @if($product->category)
                    <span class="badge text-bg-light text-muted mb-2">{{ $product->category->name }}</span>
                @endif
                <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                @if($product->short_description)
                    <p class="small text-muted mb-2" style="min-height: 2.5em;">{{ \Illuminate\Support\Str::limit($product->short_description, 90) }}</p>
                @endif
                <div class="fw-bold apc-brand-color">{{ $product->formatted_price }}</div>
            </div>
        </a>
        <div class="card-footer bg-white border-0 pt-0">
            <div class="d-flex gap-2">
                <a href="{{ route('public.products.show', $product->slug) }}" class="btn btn-sm btn-outline-dark flex-grow-1">Detail</a>
                <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageForProduct($product)) }}" target="_blank" rel="noopener" class="btn btn-sm apc-btn-wa">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</div>