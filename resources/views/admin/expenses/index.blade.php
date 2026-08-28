@extends('layouts.admin')
@section('title', 'Pengeluaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Pengeluaran</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.expense-categories.index') }}" class="btn btn-outline-secondary">Kategori</a>
        <a href="{{ route('admin.expenses.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
    </div>
</div>
<form method="get" class="row g-2 mb-3">
    <div class="col-md-3"><input type="text" name="q" value="{{ request('q') }}" placeholder="Cari deskripsi..." class="form-control"></div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">— Semua Kategori —</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
    <div class="col-md-2"><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Metode</th><th>Jumlah</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($expenses as $e)
                    <tr>
                        <td>{{ \App\Services\Formatter::dateId($e->date) }}</td>
                        <td><span class="badge text-bg-light">{{ $e->category->name ?? '-' }}</span></td>
                        <td>{{ $e->description }}</td>
                        <td>{{ \App\Models\Payment::METHODS[$e->payment_method] ?? $e->payment_method }}</td>
                        <td class="fw-semibold">{{ \App\Services\Formatter::money($e->amount) }}</td>
                        <td>
                            <a href="{{ route('admin.expenses.edit', $e) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.expenses.destroy', $e) }}" class="d-inline" data-confirm="Hapus pengeluaran ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengeluaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $expenses->links() }}</div>
</div>
@endsection