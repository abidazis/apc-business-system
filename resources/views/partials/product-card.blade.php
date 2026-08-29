@props(['product'])
<a href="{{ route('public.products.show', $product->slug) }}" class="apc-product">
    <div class="apc-product-img">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
    </div>
    <div class="apc-product-body">
        @if($product->category)
            <span class="apc-product-cat">{{ $product->category->name }}</span>
        @endif
        <h3 class="apc-product-name">{{ $product->name }}</h3>
        <div class="apc-product-foot">
            <span class="apc-product-price">{{ $product->formatted_price }}</span>
            <span class="apc-product-cta" aria-hidden="true">
                <i class="bi bi-arrow-up-right"></i>
            </span>
        </div>
    </div>
</a>