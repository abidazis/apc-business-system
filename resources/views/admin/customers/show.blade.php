@extends('layouts.admin')
@section('title', 'Detail Customer')
@section('content')
<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="apc-stat"><div class="apc-stat-label">Total Order</div><div class="apc-stat-value">{{ $customer->total_orders }}</div></div></div>
    <div class="col-md-4"><div class="apc-stat"><div class="apc-stat-label">Total Transaksi</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($customer->total_transaction) }}</div></div></div>
    <div class="col-md-4"><div class="apc-stat"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value text-danger">{{ \App\Services\Formatter::money($customer->outstanding) }}</div></div></div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Informasi Customer</h6>
        <table class="table table-sm">
            <tr><th width="160">Nama</th><td>{{ $customer->name }}</td></tr>
            <tr><th>Organisasi</th><td>{{ $customer->organization ?: '-' }}</td></tr>
            <tr><th>Telepon</th><td>{{ $customer->phone ?: '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $customer->email ?: '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $customer->address ?: '-' }}</td></tr>
            <tr><th>Catatan</th><td>{!! nl2br(e($customer->notes ?: '-')) !!}</td></tr>
        </table>
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn apc-brand-bg">Edit</a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Order Terbaru</h6></div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Order #</th><th>Tanggal</th><th>Status</th><th>Total</th><th>Outstanding</th></tr></thead>
            <tbody>
                @forelse($customer->orders as $o)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $o) }}">{{ $o->order_number }}</a></td>
                        <td>{{ \App\Services\Formatter::dateId($o->order_date) }}</td>
                        <td><span class="badge text-bg-secondary">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span></td>
                        <td>{{ \App\Services\Formatter::money($o->total) }}</td>
                        <td>{{ \App\Services\Formatter::money($o->outstanding) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection