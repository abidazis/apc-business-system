@extends('layouts.admin')
@section('title', $order->order_number)
@section('content')
    <x-admin::page-header :title="$order->order_number" :subtitle="$order->customer->name ?? '-'">
        <a href="{{ route('admin.orders.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageForOrder($order->order_number)) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-sm"><i class="bi bi-whatsapp"></i> Chat</a>
        <a href="{{ route('admin.invoices.create', ['order' => $order->id]) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Buat Invoice</a>
        <a href="{{ route('admin.orders.edit', $order) }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-pencil"></i> Edit</a>
    </x-admin::page-header>

    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3"><div class="apc-stat"><div class="apc-stat-label">Subtotal</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->subtotal) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat apc-stat-dark"><div class="apc-stat-label">Total</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->total) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat apc-stat-accent"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->outstanding) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat"><div class="apc-stat-label">Terbayar</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->total_paid) }}</div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-6">
            <div class="apc-card">
                <div class="card-body p-3 p-md-4">
                    <h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Informasi</h6>
                    <table class="apc-table" style="background: transparent;">
                        <tr><th style="width:140px;">Customer</th><td><a href="{{ route('admin.customers.show', $order->customer) }}" style="color:var(--apc-ink);font-weight:600;">{{ $order->customer->name ?? '-' }}</a></td></tr>
                        <tr><th>Tanggal</th><td>{{ \App\Services\Formatter::dateId($order->order_date) }}</td></tr>
                        <tr><th>Deadline</th><td>{{ $order->deadline ? \App\Services\Formatter::dateId($order->deadline) : '-' }}</td></tr>
                        <tr><th>Status Bayar</th><td>@php $ps = $order->payment_status; @endphp<span class="apc-badge apc-badge-{{ $ps === 'paid' ? 'success' : ($ps === 'partial' ? 'warning' : 'danger') }}">{{ $ps === 'paid' ? 'Lunas' : ($ps === 'partial' ? 'Sebagian' : 'Belum') }}</span></td></tr>
                        <tr><th>Catatan</th><td>{!! nl2br(e($order->notes ?: '-')) !!}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="apc-card">
                <div class="card-body p-3 p-md-4">
                    <h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Status Produksi & Keuangan</h6>
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-flex gap-2 mb-3">
                        @csrf
                        <select name="status" class="apc-select">
                            @foreach(\App\Models\Order::STATUSES as $k => $v)
                                <option value="{{ $k }}" {{ $order->status === $k ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                        <button class="apc-btn apc-btn-dark apc-btn-sm">Update</button>
                    </form>
                    <table class="apc-table" style="background: transparent;">
                        <tr><th>HPP Total</th><td>{{ \App\Services\Formatter::money($order->hpp_total) }}</td></tr>
                        <tr><th>Gross Profit</th><td><strong class="text-success">{{ \App\Services\Formatter::money($order->gross_profit) }}</strong></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="apc-card mb-3">
        <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;">
            <h2 style="font-size: 14px; font-weight: 700; margin: 0;">Item</h2>
        </div>
        <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
            <table class="apc-table">
                <thead><tr><th>Deskripsi</th><th>Qty</th><th>Harga</th><th>HPP</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->items as $i)
                        <tr><td>{{ $i->description }}</td><td>{{ $i->quantity }}</td><td>{{ \App\Services\Formatter::money($i->unit_price) }}</td><td>{{ \App\Services\Formatter::money($i->hpp) }}</td><td>{{ \App\Services\Formatter::money($i->subtotal) }}</td></tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="4" class="text-end">Subtotal</th><th>{{ \App\Services\Formatter::money($order->subtotal) }}</th></tr>
                    <tr><th colspan="4" class="text-end">Discount</th><th>{{ \App\Services\Formatter::money($order->discount) }}</th></tr>
                    <tr><th colspan="4" class="text-end">Shipping</th><th>{{ \App\Services\Formatter::money($order->shipping_cost) }}</th></tr>
                    <tr><th colspan="4" class="text-end">TOTAL</th><th><strong style="font-size: 16px;">{{ \App\Services\Formatter::money($order->total) }}</strong></th></tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="apc-card mb-3">
        <div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center" style="border-color: var(--apc-border) !important;">
            <h2 style="font-size: 14px; font-weight: 700; margin: 0;">Pembayaran</h2>
            <a href="{{ route('admin.payments.create', ['order' => $order->id]) }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
        </div>
        <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
            <table class="apc-table">
                <thead><tr><th>Tanggal</th><th>Metode</th><th>Jumlah</th><th>Ref</th><th>Catatan</th></tr></thead>
                <tbody>
                    @forelse($order->payments as $p)
                        <tr><td>{{ \App\Services\Formatter::dateId($p->payment_date) }}</td><td>{{ \App\Models\Payment::METHODS[$p->method] ?? $p->method }}</td><td><strong>{{ \App\Services\Formatter::money($p->amount) }}</strong></td><td>{{ $p->reference ?: '-' }}</td><td>{{ $p->notes ?: '-' }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="text-center apc-muted py-4">Belum ada pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($order->invoice)
        <div class="apc-card">
            <div class="card-body p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong>Invoice: {{ $order->invoice->invoice_number }}</strong>
                    <div class="apc-muted small">Status: {{ \App\Models\Invoice::STATUSES[$order->invoice->status] ?? $order->invoice->status }}</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Lihat Invoice</a>
                    <a href="{{ route('admin.invoices.pdf', $order->invoice) }}" target="_blank" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-file-pdf"></i> PDF</a>
                </div>
            </div>
        </div>
    @endif
@endsection