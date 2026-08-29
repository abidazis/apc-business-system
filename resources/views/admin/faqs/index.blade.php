@extends('layouts.admin')
@section('title', 'FAQ')
@section('content')
    <x-admin::page-header title="FAQ">
        <a href="{{ route('admin.faqs.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th style="width:50px;">#</th><th>Pertanyaan</th><th>Jawaban</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($faqs as $i => $f)
                    <tr>
                        <td>{{ $f->sort_order }}</td>
                        <td><strong>{{ $f->question }}</strong></td>
                        <td><small class="apc-muted">{{ \Illuminate\Support\Str::limit($f->answer, 80) }}</small></td>
                        <td><span class="apc-badge apc-badge-{{ $f->is_published ? 'success' : 'light' }}">{{ $f->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.faqs.edit', $f) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $f) }}" class="d-inline" data-confirm="Hapus FAQ ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-admin::empty-state icon="question-circle" title="Belum ada FAQ" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $faqs->links() !!}</div>
@endsection