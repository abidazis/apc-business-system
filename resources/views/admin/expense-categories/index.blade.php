@extends('layouts.admin')
@section('title', 'Kategori Pengeluaran')
@section('content')
    <x-admin::page-header title="Kategori Pengeluaran">
        <a href="{{ route('admin.expense-categories.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>
    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Nama</th><th>Slug</th><th>Digunakan</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($categories as $c)
                    <tr><td><strong>{{ $c->name }}</strong></td><td><span class="apc-mono apc-muted">{{ $c->slug }}</span></td><td>{{ $c->expenses_count }}</td>
                        <td class="text-end"><a href="{{ route('admin.expense-categories.edit', $c) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.expense-categories.destroy', $c) }}" class="d-inline" data-confirm="Hapus kategori?">@csrf @method('DELETE')<button class="apc-btn apc-btn-ghost apc-btn-sm" style="color:var(--apc-danger);"><i class="bi bi-trash"></i></button></form>
                        </td></tr>
                @empty
                    <tr><td colspan="4"><x-admin::empty-state icon="wallet2" title="Belum ada kategori" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection