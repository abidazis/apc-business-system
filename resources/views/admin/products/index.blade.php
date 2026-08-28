@extends('layouts.admin')
@section('title', 'Produk')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Produk</h4>
    <a href="{{ route('admin.products.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>

<form method="get" class="card card-body mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small mb-1">Cari</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama atau SKU...">
        </div>
        <div class="col-md-3">
            <label class="form-label small mb-1">Kategori</label>
            <select name="category" class="form-select">
                <option value="">— Semua —</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small mb-1">Status</label>
            <select name="status" class="form-select">
                <option value="">— Semua —</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-primary">Filter</button>
        </div>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $p->image_url }}" alt="" width="40" height="40" style="object-fit: cover; border-radius: 4px;">
                                <div>
                                    <strong>{{ $p->name }}</strong><br>
                                    <small class="text-muted">{{ $p->sku }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $p->category->name ?? '-' }}</td>
                        <td>{{ $p->formatted_price }}</td>
                        <td>
                            @if($p->is_published)
                                <span class="badge text-bg-success">Published</span>
                            @else
                                <span class="badge text-bg-secondary">Draft</span>
                            @endif
                            @if($p->is_featured)
                                <span class="badge text-bg-warning">Featured</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $p) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="d-inline" data-confirm="Hapus produk ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $products->links() }}</div>
</div>
@endsection