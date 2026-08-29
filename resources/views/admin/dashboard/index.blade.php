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

<div class="row g-3 mt-1">
    <div class="col-12 col-lg-7">
        <div class="apc-card">
            <div class="p-3 p-md-4 d-flex align-items-center justify-content-between border-bottom" style="border-color: var(--apc-border) !important;">
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; margin: 0;">Production Overview</h2>
                    <p class="apc-muted small mb-0">{{ $productionTotal }} order sedang dalam proses produksi.</p>
                </div>
                <a href="{{ route('admin.production.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Buka Kanban</a>
            </div>
            <div class="p-3 p-md-4">
                <div class="row g-2">
                    @php
                        $stageLabels = [
                            'confirmed' => ['label' => 'Confirmed', 'icon' => 'check2-circle'],
                            'design' => ['label' => 'Design', 'icon' => 'palette'],
                            'production' => ['label' => 'Produksi', 'icon' => 'hammer'],
                            'quality_control' => ['label' => 'QC', 'icon' => 'shield-check'],
                            'ready_to_deliver' => ['label' => 'Siap Kirim', 'icon' => 'box-seam'],
                        ];
                    @endphp
                    @foreach($productionStages as $stage)
                        <div class="col">
                            <a href="{{ route('admin.orders.index', ['status' => $stage]) }}" class="text-decoration-none">
                                <div class="apc-stat apc-stat-dark text-center">
                                    <div class="apc-stat-label"><i class="bi bi-{{ $stageLabels[$stage]['icon'] }}"></i> {{ $stageLabels[$stage]['label'] }}</div>
                                    <div class="apc-stat-value">{{ $productionCounts[$stage] ?? 0 }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="apc-card h-100">
            <div class="p-3 p-md-4 d-flex align-items-center justify-content-between border-bottom" style="border-color: var(--apc-border) !important;">
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; margin: 0;">Aktivitas Terbaru</h2>
                    <p class="apc-muted small mb-0">15 aktivitas terakhir di sistem.</p>
                </div>
            </div>
            <div class="p-3" style="max-height: 320px; overflow-y: auto;">
                @forelse($recentActivity as $a)
                    <div class="d-flex gap-2 py-2" style="border-bottom: 1px dashed var(--apc-border); font-size: 13px;">
                        <span class="apc-badge apc-badge-light" style="flex-shrink: 0;">
                            @switch($a->event)
                                @case('order.created') <i class="bi bi-receipt"></i> Order @break
                                @case('order.status_changed') <i class="bi bi-arrow-repeat"></i> Status @break
                                @case('payment.recorded') <i class="bi bi-cash-coin"></i> Bayar @break
                                @case('expense.recorded') <i class="bi bi-wallet2"></i> Expense @break
                                @case('invoice.created') <i class="bi bi-file-earmark-text"></i> Invoice @break
                                @case('settings.updated') <i class="bi bi-sliders"></i> Settings @break
                                @case('auth.login') <i class="bi bi-box-arrow-in-right"></i> Login @break
                                @case('auth.logout') <i class="bi bi-box-arrow-right"></i> Logout @break
                                @case('product.created') <i class="bi bi-box"></i> Produk @break
                                @default <i class="bi bi-circle"></i> {{ $a->event }} @break
                            @endswitch
                        </span>
                        <div class="flex-grow-1 min-w-0">
                            <div class="text-truncate">
                                {{ $a->user->name ?? '—' }}
                                <span class="apc-muted small">{{ $a->created_at->diffForHumans() }}</span>
                            </div>
                            @if($a->properties && isset($a->properties['order_number']))
                                <div class="apc-muted small">{{ $a->properties['order_number'] }}</div>
                            @elseif($a->properties && isset($a->properties['invoice_number']))
                                <div class="apc-muted small">{{ $a->properties['invoice_number'] }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center apc-muted py-4">
                        <i class="bi bi-clock-history" style="font-size:24px;"></i>
                        <div class="mt-1">Belum ada aktivitas.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection