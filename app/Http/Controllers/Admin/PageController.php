<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('slug')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:160', 'unique:pages,slug'],
            'title' => ['required', 'string', 'max:200'],
            'content' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);
        $data['is_published'] = $request->boolean('is_published');
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman dibuat.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:160', 'unique:pages,slug,' . $page->id],
            'title' => ['required', 'string', 'max:200'],
            'content' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman dihapus.');
    }
}