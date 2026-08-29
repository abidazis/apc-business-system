@extends('layouts.admin')
@section('title', 'Kategori')
@section('content')
    <x-admin::page-header title="Kategori" subtitle="Kelola kategori produk">
        <a href="{{ route('admin.categories.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
    </x-admin::page-header>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Nama</th><th>Slug</th><th>Produk</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td>
                            <strong>{{ $c->name }}</strong>
                            @if($c->description)<div class="apc-muted small">{{ \Illuminate\Support\Str::limit($c->description, 60) }}</div>@endif
                        </td>
                        <td><span class="apc-mono apc-muted">{{ $c->slug }}</span></td>
                        <td>{{ $c->products_count }}</td>
                        <td>
                            @if($c->is_active)<span class="apc-badge apc-badge-success">Aktif</span>
                            @else <span class="apc-badge apc-badge-light">Nonaktif</span>@endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $c) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="d-inline" data-confirm="Hapus kategori ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-admin::empty-state icon="tags" title="Belum ada kategori" message="Tambahkan kategori produk."><a href="{{ route('admin.categories.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a></x-admin::empty-state></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $categories->links() !!}</div>
@endsection