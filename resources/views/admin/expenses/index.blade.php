@extends('layouts.admin')
@section('title', 'Pengeluaran')
@section('content')
    <x-admin::page-header title="Pengeluaran">
        <a href="{{ route('admin.expense-categories.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Kategori</a>
        <a href="{{ route('admin.expenses.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2">
            <div class="col-md-3"><input type="text" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari deskripsi..."></div>
            <div class="col-md-3">
                <select name="category" class="apc-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><input type="date" name="from" value="{{ request('from') }}" class="apc-input" placeholder="Dari"></div>
            <div class="col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="apc-input" placeholder="Sampai"></div>
            <div class="col-md-2 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Metode</th><th>Jumlah</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($expenses as $e)
                    <tr>
                        <td>{{ \App\Services\Formatter::dateId($e->date) }}</td>
                        <td><span class="apc-badge apc-badge-light">{{ $e->category->name ?? '-' }}</span></td>
                        <td>{{ $e->description }}</td>
                        <td>{{ \App\Models\Payment::METHODS[$e->payment_method] ?? $e->payment_method }}</td>
                        <td><strong>{{ \App\Services\Formatter::money($e->amount) }}</strong></td>
                        <td class="text-end">
                            <a href="{{ route('admin.expenses.edit', $e) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.expenses.destroy', $e) }}" class="d-inline" data-confirm="Hapus pengeluaran ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-admin::empty-state icon="wallet2" title="Belum ada pengeluaran" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $expenses->links() !!}</div>
@endsection