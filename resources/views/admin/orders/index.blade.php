@extends('layouts.admin')
@section('title', 'Orders')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Orders</h4>
    <a href="{{ route('admin.orders.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor order atau customer..." class="form-control"></div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">— Semua Status —</option>
            @foreach(\App\Models\Order::STATUSES as $k => $v)
                <option value="{{ $k }}" {{ request('status') === $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary">Filter</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Order #</th><th>Tanggal</th><th>Customer</th><th>Status</th><th>Total</th><th>Outstanding</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td><strong>{{ $o->order_number }}</strong></td>
                        <td>{{ \App\Services\Formatter::dateId($o->order_date) }}<br><small class="text-muted">Deadline: {{ $o->deadline ? \App\Services\Formatter::dateId($o->deadline) : '-' }}</small></td>
                        <td>{{ $o->customer->name ?? '-' }}</td>
                        <td>
                            <span class="badge text-bg-secondary">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span>
                            @if($o->isOverdue()) <span class="badge text-bg-danger">Overdue</span> @endif
                        </td>
                        <td>{{ \App\Services\Formatter::money($o->total) }}</td>
                        <td class="text-danger fw-semibold">{{ \App\Services\Formatter::money($o->outstanding) }}</td>
                        <td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $orders->links() }}</div>
</div>
@endsection