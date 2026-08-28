@extends('layouts.admin')
@section('title', 'Kategori Pengeluaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Kategori Pengeluaran</h4>
    <a href="{{ route('admin.expense-categories.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Nama</th><th>Slug</th><th>Digunakan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong></td>
                        <td><code>{{ $c->slug }}</code></td>
                        <td>{{ $c->expenses_count }}</td>
                        <td>
                            <a href="{{ route('admin.expense-categories.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.expense-categories.destroy', $c) }}" class="d-inline" data-confirm="Hapus kategori?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection