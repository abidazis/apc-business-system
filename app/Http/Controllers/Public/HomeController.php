<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Faq;
use App\Models\PortfolioProject;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_published', true)
            ->where('is_featured', true)
            ->with('category')
            ->latest()
            ->limit(6)
            ->get();

        $latestProducts = Product::where('is_published', true)
            ->with('category')
            ->latest()
            ->limit(3)
            ->get();

        $portfolios = PortfolioProject::where('is_published', true)
            ->latest('project_date')
            ->limit(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $homepageFaqs = Faq::where('is_published', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        return view('public.home', compact(
            'featuredProducts',
            'latestProducts',
            'portfolios',
            'categories',
            'homepageFaqs'
        ));
    }
}
