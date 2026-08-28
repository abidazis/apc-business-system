<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use App\Models\PortfolioProject;
use App\Models\Product;
use App\Support\Settings;

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

        return view('public.home', compact('featuredProducts', 'latestProducts', 'portfolios'));
    }
}
