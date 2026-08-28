@extends('layouts.admin')
@section('title', 'Customer')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Customer</h4>
    <a href="{{ route('admin.customers.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<form method="get" class="mb-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, organisasi, atau phone..." class="form-control" style="max-width: 360px;">
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Customer</th><th>Kontak</th><th>Orders</th><th>Total Transaksi</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong><br><small class="text-muted">{{ $c->organization ?? '-' }}</small></td>
                        <td><small>{{ $c->phone ?? '-' }}<br>{{ $c->email ?? '' }}</small></td>
                        <td>{{ $c->orders_count }}</td>
                        <td>{{ \App\Services\Formatter::money($c->orders_sum_total ?? 0) }}</td>
                        <td>
                            <a href="{{ route('admin.customers.show', $c) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                            <a href="{{ route('admin.customers.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" class="d-inline" data-confirm="Hapus customer ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada customer.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $customers->links() }}</div>
</div>
@endsection