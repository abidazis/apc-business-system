@extends('layouts.admin')
@section('title', $customer->name)
@section('content')
    <x-admin::page-header :title="$customer->name" :actions="'<a href=&quot;' . route('admin.customers.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a> <a href=&quot;' . route('admin.customers.edit', $customer) . '&quot; class=&quot;apc-btn apc-btn-primary apc-btn-sm&quot;><i class=&quot;bi bi-pencil&quot;></i> Edit</a>'" />

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.orders.create', ['customer' => $customer->id]) }}" class="apc-btn apc-btn-dark">
            <i class="bi bi-receipt"></i> Buat Order
        </a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4"><div class="apc-stat"><div class="apc-stat-label">Total Order</div><div class="apc-stat-value">{{ $customer->total_orders }}</div></div></div>
        <div class="col-md-4"><div class="apc-stat"><div class="apc-stat-label">Total Transaksi</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($customer->total_transaction) }}</div></div></div>
        <div class="col-md-4"><div class="apc-stat apc-stat-accent"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($customer->outstanding) }}</div></div></div>
    </div>

    <div class="apc-card mb-3">
        <div class="card-body p-3 p-md-4">
            <table class="apc-table" style="background: transparent;">
                <tr><th style="width: 160px;">Nama</th><td>{{ $customer->name }}</td></tr>
                <tr><th>Organisasi</th><td>{{ $customer->organization ?: '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $customer->phone ?: '-' }}</td></tr>
                <tr><th>Email</th><td>{{ $customer->email ?: '-' }}</td></tr>
                <tr><th>Alamat</th><td>{{ $customer->address ?: '-' }}</td></tr>
                <tr><th>Catatan</th><td>{!! nl2br(e($customer->notes ?: '-')) !!}</td></tr>
            </table>
        </div>
    </div>

    <div class="apc-card">
        <div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--apc-border) !important;">
            <h2 style="font-size: 14px; font-weight: 700; margin: 0;">Order Terbaru</h2>
            <a href="{{ route('admin.orders.create', ['customer' => $customer->id]) }}" class="apc-btn apc-btn-primary apc-btn-sm">
                <i class="bi bi-plus-lg"></i> Buat Order
            </a>
        </div>
        <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
            <table class="apc-table">
                <thead><tr><th>Order #</th><th>Tanggal</th><th>Status</th><th>Total</th><th>Outstanding</th></tr></thead>
                <tbody>
                    @forelse($customer->orders as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}" style="color: var(--apc-ink); font-weight: 600;">{{ $o->order_number }}</a></td>
                            <td>{{ \App\Services\Formatter::dateId($o->order_date) }}</td>
                            <td><span class="apc-badge apc-badge-{{ $o->status === 'completed' ? 'success' : ($o->status === 'cancelled' ? 'danger' : 'light') }}">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span></td>
                            <td>{{ \App\Services\Formatter::money($o->total) }}</td>
                            <td>{{ \App\Services\Formatter::money($o->outstanding) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center apc-muted py-4">
                            <i class="bi bi-receipt" style="font-size: 24px;"></i>
                            <div class="mt-1">Belum ada order.</div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection