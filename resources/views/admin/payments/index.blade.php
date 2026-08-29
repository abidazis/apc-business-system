@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('content')
    <x-admin::page-header title="Pembayaran">
        <a href="{{ route('admin.payments.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2">
            <div class="col-md-4"><input type="text" name="order" value="{{ request('order') }}" class="apc-input" placeholder="Order ID..."></div>
            <div class="col-md-3">
                <select name="method" class="apc-select">
                    <option value="">Semua Metode</option>
                    @foreach(\App\Models\Payment::METHODS as $k => $v)
                        <option value="{{ $k }}" {{ request('method') === $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Tanggal</th><th>Order</th><th>Customer</th><th>Metode</th><th>Jumlah</th><th>Ref</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($payments as $p)
                    <tr>
                        <td>{{ \App\Services\Formatter::dateId($p->payment_date) }}</td>
                        <td><a href="{{ route('admin.orders.show', $p->order) }}" style="color: var(--apc-ink); font-weight: 600;">{{ $p->order->order_number ?? '-' }}</a></td>
                        <td>{{ $p->order->customer->name ?? '-' }}</td>
                        <td>{{ \App\Models\Payment::METHODS[$p->method] ?? $p->method }}</td>
                        <td><strong>{{ \App\Services\Formatter::money($p->amount) }}</strong></td>
                        <td>{{ $p->reference ?: '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.payments.edit', $p) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.payments.destroy', $p) }}" class="d-inline" data-confirm="Hapus pembayaran ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-admin::empty-state icon="cash" title="Belum ada pembayaran" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $payments->links() !!}</div>
@endsection