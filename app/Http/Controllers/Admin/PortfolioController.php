<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\PortfolioImage;
use App\Models\PortfolioProject;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $projects = PortfolioProject::withCount('images')
            ->when($request->get('q'), fn ($q, $term) => $q->where('title', 'like', "%{$term}%"))
            ->latest('project_date')
            ->paginate(20)
            ->withQueryString();
        return view('admin.portfolio.index', compact('projects'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.portfolio.create', compact('products'));
    }

    public function store(PortfolioRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }

        $project = PortfolioProject::create($data);

        $this->syncProducts($project, $request);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio dibuat.');
    }

    public function show(PortfolioProject $portfolio)
    {
        $portfolio->load(['images', 'products']);
        return view('admin.portfolio.show', compact('portfolio'));
    }

    public function edit(PortfolioProject $portfolio)
    {
        $products = Product::orderBy('name')->get();
        $portfolio->load('images', 'products');
        $attached = $portfolio->products->pluck('pivot.quantity', 'id')->toArray();
        return view('admin.portfolio.edit', compact('portfolio', 'products', 'attached'));
    }

    public function update(PortfolioRequest $request, PortfolioProject $portfolio)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            if ($portfolio->cover_image) {
                Storage::disk('public')->delete($portfolio->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }

        $portfolio->update($data);
        $this->syncProducts($portfolio, $request);

        return redirect()->route('admin.portfolio.show', $portfolio)->with('success', 'Portfolio diperbarui.');
    }

    public function destroy(PortfolioProject $portfolio)
    {
        foreach ($portfolio->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        if ($portfolio->cover_image) {
            Storage::disk('public')->delete($portfolio->cover_image);
        }
        $portfolio->delete();
        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio dihapus.');
    }

    public function uploadImage(Request $request, PortfolioProject $portfolio)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);
        $path = $request->file('image')->store('portfolio', 'public');
        $portfolio->images()->create([
            'image' => $path,
            'caption' => $request->caption,
            'sort_order' => $portfolio->images()->count(),
        ]);
        return back()->with('success', 'Gambar ditambahkan.');
    }

    public function deleteImage(PortfolioImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Gambar dihapus.');
    }

    private function syncProducts(PortfolioProject $portfolio, Request $request): void
    {
        $products = $request->input('products', []);
        $quantities = $request->input('product_quantities', []);
        $sync = [];
        foreach ($products as $pid) {
            $sync[$pid] = ['quantity' => (int) ($quantities[$pid] ?? 1)];
        }
        $portfolio->products()->sync($sync);
    }
}