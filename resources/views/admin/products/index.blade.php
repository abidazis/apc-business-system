@extends('layouts.admin')
@section('title', 'Produk')

@section('content')
    <x-admin::page-header title="Produk" subtitle="Kelola katalog produk APC">
        <a href="{{ route('admin.products.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah Produk</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2 align-items-end">
            <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari nama atau SKU..."></div>
            <div class="col-md-3">
                <select name="category" class="apc-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="apc-select">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead>
                <tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $p->image_url }}" alt="" width="40" height="40" style="object-fit: cover; border-radius: 8px; background: var(--apc-gray-100);">
                                <div>
                                    <div style="font-weight: 600;">{{ $p->name }}</div>
                                    <div class="apc-mono apc-muted" style="font-size: 11px;">{{ $p->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $p->category->name ?? '-' }}</td>
                        <td>{{ $p->formatted_price }}</td>
                        <td>
                            @if($p->is_published)<span class="apc-badge apc-badge-success">Published</span>
                            @else <span class="apc-badge apc-badge-light">Draft</span>@endif
                            @if($p->is_featured)<span class="apc-badge apc-badge-warning ms-1">Featured</span>@endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.show', $p) }}" class="apc-btn apc-btn-ghost apc-btn-sm" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.products.edit', $p) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="d-inline" data-confirm="Hapus produk ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">
                        <x-admin::empty-state icon="box" title="Belum ada produk" message="Tambahkan produk pertama Anda.">
                            <a href="{{ route('admin.products.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah Produk</a>
                        </x-admin::empty-state>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $products->links() !!}</div>
@endsection