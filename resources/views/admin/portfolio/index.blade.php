@extends('layouts.admin')
@section('title', 'Portfolio')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Portfolio</h4>
    <a href="{{ route('admin.portfolio.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Judul</th><th>Customer</th><th>Tanggal</th><th>Gambar</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($projects as $p)
                    <tr>
                        <td><strong>{{ $p->title }}</strong><br><small class="text-muted">{{ $p->slug }}</small></td>
                        <td>{{ $p->customer_name ?: '-' }}</td>
                        <td>{{ $p->project_date ? \App\Services\Formatter::dateId($p->project_date) : '-' }}</td>
                        <td>{{ $p->images_count }}</td>
                        <td><span class="badge text-bg-{{ $p->is_published ? 'success' : 'secondary' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td>
                            <a href="{{ route('admin.portfolio.show', $p) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                            <a href="{{ route('admin.portfolio.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.portfolio.destroy', $p) }}" class="d-inline" data-confirm="Hapus portfolio ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada portfolio.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $projects->links() }}</div>
</div>
@endsection