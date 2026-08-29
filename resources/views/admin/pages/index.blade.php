@extends('layouts.admin')
@section('title', 'Halaman')
@section('content')
    <x-admin::page-header title="Halaman Statis">
        <a href="{{ route('admin.pages.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>
    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Slug</th><th>Judul</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($pages as $p)
                    <tr><td><span class="apc-mono apc-muted">{{ $p->slug }}</span></td><td>{{ $p->title }}</td><td><span class="apc-badge apc-badge-{{ $p->is_published ? 'success' : 'light' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end"><a href="{{ route('admin.pages.edit', $p) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a> <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" class="d-inline" data-confirm="Hapus halaman?">@csrf @method('DELETE')<button class="apc-btn apc-btn-ghost apc-btn-sm" style="color:var(--apc-danger);"><i class="bi bi-trash"></i></button></form></td></tr>
                @empty
                    <tr><td colspan="4"><x-admin::empty-state icon="file-text" title="Belum ada halaman" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection