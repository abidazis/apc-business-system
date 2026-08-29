@extends('layouts.admin')
@section('title', 'Dashboard')

@php
    $presetLabels = ['today' => 'Hari Ini', 'this_week' => 'Minggu Ini', 'this_month' => 'Bulan Ini', 'this_year' => 'Tahun Ini'];
    $stats = [
        ['key' => 'omzet',       'label' => 'Omset',            'value' => \App\Services\Formatter::money($omzet),     'icon' => 'cash-stack', 'accent' => false],
        ['key' => 'payment',     'label' => 'Uang Masuk',       'value' => \App\Services\Formatter::money($paymentIn), 'icon' => 'arrow-down-circle', 'accent' => false],
        ['key' => 'piutang',     'label' => 'Piutang',          'value' => \App\Services\Formatter::money($piutang),   'icon' => 'hourglass-split', 'accent' => true],
        ['key' => 'expense',     'label' => 'Pengeluaran',      'value' => \App\Services\Formatter::money($expenseIn), 'icon' => 'wallet2', 'accent' => false],
        ['key' => 'hpp',         'label' => 'HPP',              'value' => \App\Services\Formatter::money($hpp),       'icon' => 'box-seam', 'accent' => false],
        ['key' => 'gross',       'label' => 'Gross Profit',     'value' => \App\Services\Formatter::money($grossProfit),'icon' => 'graph-up', 'accent' => true],
        ['key' => 'net',         'label' => 'Net Profit',       'value' => \App\Services\Formatter::money($netProfit), 'icon' => 'piggy-bank', 'accent' => true],
        ['key' => 'orders',      'label' => 'Order Aktif',      'value' => $orderCount,                                 'icon' => 'receipt',  'accent' => false],
    ];
@endphp

@section('content')
<div class="apc-page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="apc-muted mb-0" style="font-size: 14px;">Ringkasan operasional & keuangan · {{ $presetLabels[$preset] ?? ucfirst($preset) }}</p>
    </div>
    <form method="get" class="d-flex gap-2">
        <select name="preset" class="apc-select" style="min-width:160px;" onchange="this.form.submit()">
            <option value="today" {{ $preset === 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="this_week" {{ $preset === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
            <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
        @if($preset === 'custom')
            <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="apc-input" style="width:auto;">
            <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="apc-input" style="width:auto;">
            <button class="apc-btn apc-btn-dark apc-btn-sm">Apply</button>
        @endif
    </form>
</div>

<div class="apc-admin-kpi">
    @foreach($stats as $s)
        <div class="apc-stat {{ $s['accent'] ? 'apc-stat-accent' : '' }}">
            <div class="apc-stat-label"><i class="bi bi-{{ $s['icon'] }}"></i> {{ $s['label'] }}</div>
            <div class="apc-stat-value">{{ $s['value'] }}</div>
        </div>
    @endforeach
</div>

<div class="mt-4 apc-card">
    <div class="p-3 p-md-4 d-flex align-items-center justify-content-between border-bottom" style="border-color: var(--apc-border) !important;">
        <div>
            <h2 style="font-size: 16px; font-weight: 700; margin: 0;">Order Perlu Perhatian</h2>
            <p class="apc-muted small mb-0">Deadline dekat, terlambat, atau belum dibayar.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Lihat semua</a>
    </div>
    <div class="apc-table-wrap" style="border: 0; border-radius: 0;">
        <table class="apc-table mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Deadline</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Bayar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($needsAttention as $o)
                    <tr>
                        <td><strong>{{ $o->order_number }}</strong></td>
                        <td>{{ $o->customer->name ?? '-' }}</td>
                        <td>
                            @if($o->deadline)
                                <span class="{{ $o->isOverdue() ? 'text-danger fw-semibold' : '' }}">
                                    {{ \App\Services\Formatter::dateId($o->deadline) }}
                                </span>
                            @else - @endif
                        </td>
                        <td>{{ \App\Services\Formatter::money($o->total) }}</td>
                        <td><span class="apc-badge apc-badge-light">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span></td>
                        <td>
                            @php $ps = $o->payment_status; @endphp
                            <span class="apc-badge apc-badge-{{ $ps === 'paid' ? 'success' : ($ps === 'partial' ? 'warning' : 'danger') }}">
                                {{ $ps === 'paid' ? 'Lunas' : ($ps === 'partial' ? 'Sebagian' : 'Belum') }}
                            </span>
                        </td>
                        <td class="text-end"><a href="{{ route('admin.orders.show', $o) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center apc-muted py-5">
                        <i class="bi bi-check2-circle" style="font-size:24px;"></i>
                        <div class="mt-1">Tidak ada order yang perlu perhatian.</div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection