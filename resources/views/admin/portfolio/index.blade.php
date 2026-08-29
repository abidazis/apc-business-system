@extends('layouts.admin')
@section('title', 'Portfolio')
@section('content')
    <x-admin::page-header title="Portfolio">
        <a href="{{ route('admin.portfolio.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Judul</th><th>Customer</th><th>Tanggal</th><th>Gambar</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($projects as $p)
                    <tr>
                        <td>
                            <strong>{{ $p->title }}</strong>
                            <div class="apc-muted small">{{ $p->slug }}</div>
                        </td>
                        <td>{{ $p->customer_name ?: '-' }}</td>
                        <td>{{ $p->project_date ? \App\Services\Formatter::dateId($p->project_date) : '-' }}</td>
                        <td>{{ $p->images_count }}</td>
                        <td><span class="apc-badge apc-badge-{{ $p->is_published ? 'success' : 'light' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.portfolio.show', $p) }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.portfolio.edit', $p) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.portfolio.destroy', $p) }}" class="d-inline" data-confirm="Hapus portfolio ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-admin::empty-state icon="images" title="Belum ada portfolio" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $projects->links() !!}</div>
@endsection