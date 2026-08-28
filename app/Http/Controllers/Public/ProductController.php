<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\WhatsApp;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_published', true)])
            ->orderBy('sort_order')
            ->get();

        $products = Product::where('is_published', true)
            ->with('category')
            ->when(request('category'), fn ($q, $slug) =>
                $q->whereHas('category', fn ($qq) => $qq->where('slug', $slug)))
            ->when(request('q'), fn ($q, $term) =>
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', "%{$term}%")
                        ->orWhere('short_description', 'like', "%{$term}%");
                }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_published', true)
            ->with('category')
            ->firstOrFail();

        $related = Product::where('is_published', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->limit(4)
            ->get();

        $whatsappUrl = WhatsApp::url(WhatsApp::messageForProduct($product));

        return view('public.products.show', compact('product', 'related', 'whatsappUrl'));
    }
}
