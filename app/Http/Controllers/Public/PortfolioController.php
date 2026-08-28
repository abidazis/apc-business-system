<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = PortfolioProject::where('is_published', true)
            ->with('images')
            ->latest('project_date')
            ->paginate(9);

        return view('public.portfolio.index', compact('portfolios'));
    }

    public function show(string $slug)
    {
        $project = PortfolioProject::where('slug', $slug)
            ->where('is_published', true)
            ->with(['images', 'products'])
            ->firstOrFail();

        return view('public.portfolio.show', compact('project'));
    }
}
