@extends('layouts.admin')
@section('title', 'Laporan')
@section('content')
    <x-admin::page-header title="Laporan Keuangan">
        <form method="get" class="d-flex gap-2">
            <select name="preset" class="apc-select" onchange="this.form.submit()">
                <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
            @if($preset === 'custom')
                <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="apc-input" style="width:auto;">
                <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="apc-input" style="width:auto;">
                <button class="apc-btn apc-btn-primary apc-btn-sm">Apply</button>
            @endif
        </form>
    </x-admin::page-header>

    @php
        $r = [
            ['Revenue', $revenue, 'primary', 'cash-stack'],
            ['Uang Masuk', $payment, 'success', 'arrow-down-circle'],
            ['Pengeluaran', $expense, 'danger', 'wallet2'],
            ['HPP', $hpp, 'secondary', 'box-seam'],
            ['Gross Profit', $grossProfit, 'info', 'graph-up'],
            ['Net Profit', $netProfit, $netProfit >= 0 ? 'success' : 'danger', 'piggy-bank'],
        ];
    @endphp
    <div class="apc-admin-kpi">
        @foreach($r as $stat)
            <div class="apc-stat"><div class="apc-stat-label"><i class="bi bi-{{ $stat[3] }}"></i> {{ $stat[0] }}</div><div class="apc-stat-value text-{{ $stat[2] }}">{{ \App\Services\Formatter::money($stat[1]) }}</div></div>
        @endforeach
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="apc-card">
                <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Top Customer</h2></div>
                <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
                    <table class="apc-table">
                        <thead><tr><th>Customer</th><th>Total Transaksi</th></tr></thead>
                        <tbody>
                            @forelse($topCustomers as $c)
                                <tr><td>{{ $c->name }}</td><td><strong>{{ \App\Services\Formatter::money($c->total_orders_value ?? 0) }}</strong></td></tr>
                            @empty
                                <tr><td colspan="2" class="text-center apc-muted py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="apc-card">
                <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Top Produk</h2></div>
                <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
                    <table class="apc-table">
                        <thead><tr><th>Produk</th><th>Qty</th><th>Revenue</th></tr></thead>
                        <tbody>
                            @forelse($topProducts as $p)
                                <tr><td>{{ $p->name }}</td><td>{{ $p->qty }}</td><td><strong>{{ \App\Services\Formatter::money($p->revenue) }}</strong></td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center apc-muted py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="apc-card mt-3">
        <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Order · {{ $start->format('d M') }} - {{ $end->format('d M Y') }}</h2></div>
        <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
            <table class="apc-table">
                <thead><tr><th>Order</th><th>Tanggal</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead>
                <tbody>
                    @forelse($orders as $o)
                        <tr><td><a href="{{ route('admin.orders.show', $o) }}" style="color:var(--apc-ink);font-weight:600;">{{ $o->order_number }}</a></td><td>{{ \App\Services\Formatter::dateId($o->order_date) }}</td><td>{{ $o->customer->name ?? '-' }}</td><td><span class="apc-badge apc-badge-light">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span></td><td>{{ \App\Services\Formatter::money($o->total) }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="text-center apc-muted py-4">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection