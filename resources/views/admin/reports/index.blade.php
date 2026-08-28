@extends('layouts.admin')
@section('title', 'Laporan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Laporan Keuangan</h4>
    <form method="get" class="d-flex gap-2">
        <select name="preset" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
            <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
        @if($preset === 'custom')
            <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="form-control form-control-sm">
            <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="form-control form-control-sm">
            <button class="btn btn-sm btn-primary">Apply</button>
        @endif
    </form>
</div>

@php
    $r = [
        ['Revenue', $revenue, 'primary'],
        ['Uang Masuk', $payment, 'success'],
        ['Pengeluaran', $expense, 'danger'],
        ['HPP', $hpp, 'secondary'],
        ['Gross Profit', $grossProfit, 'info'],
        ['Net Profit', $netProfit, $netProfit >= 0 ? 'success' : 'danger'],
    ];
@endphp
<div class="row g-3 mb-3">
    @foreach($r as $stat)
        <div class="col-6 col-md-4 col-lg-2"><div class="apc-stat h-100"><div class="apc-stat-label">{{ $stat[0] }}</div><div class="apc-stat-value text-{{ $stat[2] }}">{{ \App\Services\Formatter::money($stat[1]) }}</div></div></div>
    @endforeach
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white"><h6 class="fw-bold mb-0">Top Customer</h6></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Customer</th><th>Total Transaksi</th></tr></thead>
                    <tbody>
                        @forelse($topCustomers as $c)
                            <tr><td>{{ $c->name }}</td><td>{{ \App\Services\Formatter::money($c->total_orders_value ?? 0) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted py-3">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white"><h6 class="fw-bold mb-0">Top Produk</h6></div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Produk</th><th>Qty</th><th>Revenue</th></tr></thead>
                    <tbody>
                        @forelse($topProducts as $p)
                            <tr><td>{{ $p->name }}</td><td>{{ $p->qty }}</td><td>{{ \App\Services\Formatter::money($p->revenue) }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Order ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})</h6></div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Order</th><th>Tanggal</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
                @forelse($orders as $o)
                    <tr><td><a href="{{ route('admin.orders.show', $o) }}">{{ $o->order_number }}</a></td><td>{{ \App\Services\Formatter::dateId($o->order_date) }}</td><td>{{ $o->customer->name ?? '-' }}</td><td>{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</td><td>{{ \App\Services\Formatter::money($o->total) }}</td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection