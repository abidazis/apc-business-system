@extends('layouts.admin')
@section('title', 'Orders')
@section('content')
    <x-admin::page-header title="Orders" subtitle="Kelola semua pesanan">
        <a href="{{ route('admin.orders.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah Order</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2">
            <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari nomor order atau customer..."></div>
            <div class="col-md-4">
                <select name="status" class="apc-select">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Order::STATUSES as $k => $v)
                        <option value="{{ $k }}" {{ request('status') === $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Order #</th><th>Tanggal</th><th>Customer</th><th>Status</th><th>Total</th><th>Outstanding</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td><strong>{{ $o->order_number }}</strong></td>
                        <td>
                            <div>{{ \App\Services\Formatter::dateId($o->order_date) }}</div>
                            <div class="apc-muted small">Deadline: {{ $o->deadline ? \App\Services\Formatter::dateId($o->deadline) : '-' }}</div>
                        </td>
                        <td>{{ $o->customer->name ?? '-' }}</td>
                        <td>
                            <span class="apc-badge apc-badge-light">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span>
                            @if($o->isOverdue())<div class="apc-badge apc-badge-danger mt-1">Overdue</div>@endif
                        </td>
                        <td><strong>{{ \App\Services\Formatter::money($o->total) }}</strong></td>
                        <td class="text-danger fw-semibold">{{ \App\Services\Formatter::money($o->outstanding) }}</td>
                        <td class="text-end"><a href="{{ route('admin.orders.show', $o) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-admin::empty-state icon="receipt" title="Belum ada order" message="Buat order pertama Anda."><a href="{{ route('admin.orders.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Buat Order</a></x-admin::empty-state></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $orders->links() !!}</div>
@endsection