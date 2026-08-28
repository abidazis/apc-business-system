@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Pembayaran</h4>
    <a href="{{ route('admin.payments.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<form method="get" class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="order" value="{{ request('order') }}" placeholder="Order ID..." class="form-control"></div>
    <div class="col-md-3">
        <select name="method" class="form-select">
            <option value="">— Semua Metode —</option>
            @foreach(\App\Models\Payment::METHODS as $k => $v)
                <option value="{{ $k }}" {{ request('method') === $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Tanggal</th><th>Order</th><th>Customer</th><th>Metode</th><th>Jumlah</th><th>Ref</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($payments as $p)
                    <tr>
                        <td>{{ \App\Services\Formatter::dateId($p->payment_date) }}</td>
                        <td><a href="{{ route('admin.orders.show', $p->order) }}">{{ $p->order->order_number ?? '-' }}</a></td>
                        <td>{{ $p->order->customer->name ?? '-' }}</td>
                        <td>{{ \App\Models\Payment::METHODS[$p->method] ?? $p->method }}</td>
                        <td class="fw-semibold">{{ \App\Services\Formatter::money($p->amount) }}</td>
                        <td>{{ $p->reference ?: '-' }}</td>
                        <td>
                            <a href="{{ route('admin.payments.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.payments.destroy', $p) }}" class="d-inline" data-confirm="Hapus pembayaran ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $payments->links() }}</div>
</div>
@endsection