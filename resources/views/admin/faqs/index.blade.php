@extends('layouts.admin')
@section('title', 'FAQ')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">FAQ</h4>
    <a href="{{ route('admin.faqs.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Pertanyaan</th><th>Jawaban</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($faqs as $i => $f)
                    <tr>
                        <td>{{ $f->sort_order }}</td>
                        <td><strong>{{ $f->question }}</strong></td>
                        <td><small>{{ \Illuminate\Support\Str::limit($f->answer, 80) }}</small></td>
                        <td><span class="badge text-bg-{{ $f->is_published ? 'success' : 'secondary' }}">{{ $f->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td>
                            <a href="{{ route('admin.faqs.edit', $f) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $f) }}" class="d-inline" data-confirm="Hapus FAQ ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada FAQ.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $faqs->links() }}</div>
</div>
@endsection