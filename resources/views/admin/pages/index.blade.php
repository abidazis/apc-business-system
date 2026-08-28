@extends('layouts.admin')
@section('title', 'Halaman')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Halaman Statis</h4>
    <a href="{{ route('admin.pages.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Slug</th><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pages as $p)
                    <tr>
                        <td><code>{{ $p->slug }}</code></td>
                        <td>{{ $p->title }}</td>
                        <td><span class="badge text-bg-{{ $p->is_published ? 'success' : 'secondary' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" class="d-inline" data-confirm="Hapus halaman?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada halaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection