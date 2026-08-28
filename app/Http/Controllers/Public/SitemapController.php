<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            url('/'),
            url('/produk'),
            url('/portfolio'),
            url('/tentang'),
            url('/faq'),
            url('/kontak'),
        ]);

        Product::where('is_published', true)
            ->orderByDesc('updated_at')
            ->limit(500)
            ->get()
            ->each(fn ($p) => $urls->push(route('public.products.show', $p->slug)));

        PortfolioProject::where('is_published', true)
            ->orderByDesc('updated_at')
            ->limit(500)
            ->get()
            ->each(fn ($p) => $urls->push(route('public.portfolio.show', $p->slug)));

        $content = view('public.sitemap', ['urls' => $urls])->render();
        $content = preg_replace('/^@php.*?@endphp\n?/s', '', $content);

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
