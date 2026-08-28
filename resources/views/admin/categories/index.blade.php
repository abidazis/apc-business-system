@extends('layouts.admin')
@section('title', 'Kategori')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Kategori Produk</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Nama</th><th>Slug</th><th>Produk</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong><br><small class="text-muted">{{ \Illuminate\Support\Str::limit($c->description, 60) }}</small></td>
                        <td><code>{{ $c->slug }}</code></td>
                        <td>{{ $c->products_count }}</td>
                        <td><span class="badge text-bg-{{ $c->is_active ? 'success' : 'secondary' }}">{{ $c->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="d-inline" data-confirm="Hapus kategori ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $categories->links() }}</div>
</div>
@endsection