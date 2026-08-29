<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->get('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%")->orWhere('sku', 'like', "%{$term}%"))
            ->when($request->get('category'), fn ($q, $id) => $q->where('category_id', $id))
            ->when($request->get('status'), fn ($q, $status) => $status === 'published' ? $q->where('is_published', true)
                : ($status === 'draft' ? $q->where('is_published', false) : null))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        Activity::record('product.created', Product::latest('id')->first());

        return redirect()->route('admin.products.index')->with('success', 'Produk dibuat.');
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        Activity::record('product.updated', $product);

        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $productId = $product->id;
        $product->delete();
        Activity::record('product.deleted', null, ['product_id' => $productId]);

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }
}
