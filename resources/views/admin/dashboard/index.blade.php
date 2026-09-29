@extends('layouts.admin')
@section('title', 'Dashboard')

@php
    $presetLabels = ['today' => 'Hari Ini', 'this_week' => 'Minggu Ini', 'this_month' => 'Bulan Ini', 'this_year' => 'Tahun Ini'];

    // Profit margin calculation
    $profitMargin = $omzet > 0 ? round(($netProfit / $omzet) * 100, 1) : 0;

    // Payment ratio
    $paymentRatio = $omzet > 0 ? round(($paymentIn / $omzet) * 100, 1) : 0;

    // Status labels
    $statusLabels = [
        'confirmed' => ['label' => 'Confirmed', 'icon' => 'check2-circle', 'color' => 'info'],
        'dp_received' => ['label' => 'DP Diterima', 'icon' => 'credit-card', 'color' => 'warning'],
        'design' => ['label' => 'Design', 'icon' => 'palette', 'color' => 'primary'],
        'production' => ['label' => 'Produksi', 'icon' => 'hammer', 'color' => 'secondary'],
        'quality_control' => ['label' => 'QC', 'icon' => 'shield-check', 'color' => 'info'],
        'ready_to_deliver' => ['label' => 'Siap Kirim', 'icon' => 'truck', 'color' => 'success'],
        'completed' => ['label' => 'Selesai', 'icon' => 'check-circle', 'color' => 'success'],
        'cancelled' => ['label' => 'Batal', 'icon' => 'x-circle', 'color' => 'danger'],
    ];

    $stageLabels = [
        'confirmed' => ['label' => 'Confirmed', 'icon' => 'check2-circle'],
        'design' => ['label' => 'Design', 'icon' => 'palette'],
        'production' => ['label' => 'Produksi', 'icon' => 'hammer'],
        'quality_control' => ['label' => 'QC', 'icon' => 'shield-check'],
        'ready_to_deliver' => ['label' => 'Siap Kirim', 'icon' => 'box-seam'],
    ];
@endphp

@push('styles')
<style>
/* Dashboard Enhancement */
.apc-dash-greeting {
    background: linear-gradient(135deg, var(--apc-ink) 0%, var(--apc-ink-2) 100%);
    border-radius: var(--apc-radius-xl);
    padding: 28px 32px;
    color: var(--apc-white);
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}
.apc-dash-greeting::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: var(--apc-yellow);
    border-radius: 50%;
    opacity: .08;
}
.apc-dash-greeting h1 {
    color: var(--apc-white);
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin: 0 0 4px;
}
.apc-dash-greeting p {
    color: rgba(255,255,255,.7);
    margin: 0;
    font-size: 14px;
}
.apc-dash-greeting-meta {
    display: flex;
    gap: 16px;
    margin-top: 16px;
    flex-wrap: wrap;
}
.apc-dash-greeting-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: rgba(255,255,255,.6);
}
.apc-dash-greeting-meta .highlight {
    color: var(--apc-yellow);
    font-weight: 700;
}
.apc-dash-quick-actions {
    display: flex;
    gap: 8px;
    margin-top: 20px;
}
.apc-dash-quick-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 8px;
    color: var(--apc-white);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background .15s;
}
.apc-dash-quick-btn:hover {
    background: rgba(255,255,255,.2);
    color: var(--apc-white);
    text-decoration: none;
}

/* KPI Cards Enhanced */
.apc-kpi-card {
    background: var(--apc-white);
    border: 1px solid var(--apc-border);
    border-radius: var(--apc-radius-lg);
    padding: 20px;
    position: relative;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
}
.apc-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--apc-shadow);
}
.apc-kpi-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}
.apc-kpi-card.yellow::before { background: var(--apc-yellow); }
.apc-kpi-card.green::before { background: var(--apc-success); }
.apc-kpi-card.red::before { background: var(--apc-danger); }
.apc-kpi-card.blue::before { background: var(--apc-info); }
.apc-kpi-card.gray::before { background: var(--apc-gray-400); }

.apc-kpi-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}
.apc-kpi-icon i { font-size: 22px; }
.apc-kpi-icon.yellow { background: rgba(255,198,0,.15); color: var(--apc-yellow-dark); }
.apc-kpi-icon.green { background: rgba(22,163,74,.12); color: var(--apc-success); }
.apc-kpi-icon.red { background: rgba(220,38,38,.1); color: var(--apc-danger); }
.apc-kpi-icon.blue { background: rgba(37,99,235,.1); color: var(--apc-info); }
.apc-kpi-icon.gray { background: var(--apc-gray-100); color: var(--apc-gray-600); }

.apc-kpi-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--apc-text-muted);
    margin-bottom: 4px;
}
.apc-kpi-value {
    font-size: 26px;
    font-weight: 800;
    color: var(--apc-ink);
    letter-spacing: -0.02em;
    line-height: 1.1;
}
.apc-kpi-change {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 8px;
    padding: 4px 8px;
    border-radius: 6px;
}
.apc-kpi-change.positive { background: rgba(22,163,74,.1); color: var(--apc-success); }
.apc-kpi-change.negative { background: rgba(220,38,38,.1); color: var(--apc-danger); }
.apc-kpi-change.neutral { background: var(--apc-gray-100); color: var(--apc-text-muted); }

/* Mini Progress Bar */
.apc-progress-mini {
    height: 6px;
    background: var(--apc-gray-200);
    border-radius: 999px;
    overflow: hidden;
    margin-top: 10px;
}
.apc-progress-mini-bar {
    height: 100%;
    border-radius: 999px;
    transition: width .5s ease;
}

/* Alert Cards */
.apc-alert-card {
    background: var(--apc-white);
    border: 1px solid var(--apc-border);
    border-radius: var(--apc-radius-lg);
    overflow: hidden;
}
.apc-alert-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--apc-border);
}
.apc-alert-card-header h2 {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.apc-alert-card-header h2 i { font-size: 18px; }
.apc-alert-card-header .badge {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
}
.apc-alert-card-body { padding: 0; }

/* Alert Items */
.apc-alert-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--apc-border);
    transition: background .15s;
}
.apc-alert-item:last-child { border-bottom: 0; }
.apc-alert-item:hover { background: var(--apc-gray-50); }
.apc-alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.apc-alert-icon.danger { background: rgba(220,38,38,.1); color: var(--apc-danger); }
.apc-alert-icon.warning { background: rgba(245,158,11,.12); color: #B45309; }
.apc-alert-icon i { font-size: 18px; }
.apc-alert-info { flex: 1; min-width: 0; }
.apc-alert-info strong { display: block; font-size: 14px; color: var(--apc-ink); margin-bottom: 2px; }
.apc-alert-info span { font-size: 12px; color: var(--apc-text-muted); }
.apc-alert-action { flex-shrink: 0; }

/* Production Stage Card */
.apc-stage-card {
    background: var(--apc-black);
    color: var(--apc-white);
    border-radius: var(--apc-radius-lg);
    padding: 16px;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: transform .2s, box-shadow .2s;
}
.apc-stage-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--apc-shadow-lg);
    color: var(--apc-white);
    text-decoration: none;
}
.apc-stage-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(255,198,0,.15);
    color: var(--apc-yellow);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}
.apc-stage-icon i { font-size: 24px; }
.apc-stage-count {
    font-size: 28px;
    font-weight: 800;
    color: var(--apc-yellow);
    letter-spacing: -0.03em;
    line-height: 1;
    margin-bottom: 4px;
}
.apc-stage-label {
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* Activity Feed */
.apc-activity-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed var(--apc-border);
}
.apc-activity-item:last-child { border-bottom: 0; }
.apc-activity-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--apc-gray-300);
    margin-top: 6px;
    flex-shrink: 0;
}
.apc-activity-dot.order { background: var(--apc-info); }
.apc-activity-dot.payment { background: var(--apc-success); }
.apc-activity-dot.expense { background: var(--apc-danger); }
.apc-activity-dot.auth { background: var(--apc-gray-400); }
.apc-activity-content { flex: 1; }
.apc-activity-content strong { font-size: 13px; color: var(--apc-ink); }
.apc-activity-content span { font-size: 12px; color: var(--apc-text-muted); display: block; }
.apc-activity-time { font-size: 11px; color: var(--apc-text-subtle); flex-shrink: 0; }

/* Empty State */
.apc-empty-state {
    text-align: center;
    padding: 32px 20px;
    color: var(--apc-text-muted);
}
.apc-empty-state i { font-size: 32px; margin-bottom: 8px; opacity: .5; }
.apc-empty-state p { font-size: 13px; margin: 0; }

/* Section Header */
.apc-dash-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.apc-dash-section-head h2 {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.apc-dash-section-head h2 i { font-size: 20px; color: var(--apc-text-muted); }

/* Info Cards Row */
.apc-info-row {
    display: grid;
    gap: 14px;
    grid-template-columns: 1fr;
    margin-bottom: 24px;
}
@media (min-width: 768px) { .apc-info-row { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 1024px) { .apc-info-row { grid-template-columns: repeat(6, 1fr); } }

.apc-info-card {
    background: var(--apc-white);
    border: 1px solid var(--apc-border);
    border-radius: var(--apc-radius);
    padding: 16px;
    text-align: center;
}
.apc-info-card-value {
    font-size: 22px;
    font-weight: 800;
    color: var(--apc-ink);
    letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.apc-info-card-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--apc-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
</style>
@endpush

@section('content')
{{-- Greeting Header --}}
<div class="apc-dash-greeting">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p>Berikut ringkasan performa bisnis Anda pada periode <strong>{{ $presetLabels[$preset] ?? ucfirst($preset) }}</strong></p>
            <div class="apc-dash-greeting-meta">
                <span><i class="bi bi-calendar3"></i> {{ \App\Services\Formatter::dateId($start) }} — {{ \App\Services\Formatter::dateId($end) }}</span>
                <span><i class="bi bi-clock"></i> Update: {{ now()->format('H:i') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="apc-dash-quick-actions">
                <a href="{{ route('admin.orders.create') }}" class="apc-dash-quick-btn">
                    <i class="bi bi-plus-circle"></i> Order Baru
                </a>
                <a href="{{ route('admin.payments.create') }}" class="apc-dash-quick-btn">
                    <i class="bi bi-cash-stack"></i> Catat Bayar
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Filter --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div class="d-flex align-items-center gap-2">
        <form method="get" class="d-flex gap-2">
            <select name="preset" class="apc-select" style="min-width: 160px;" onchange="this.form.submit()">
                <option value="today" {{ $preset === 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="this_week" {{ $preset === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
            @if($preset === 'custom')
                <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="apc-input" style="width: auto;">
                <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="apc-input" style="width: auto;">
                <button class="apc-btn apc-btn-dark apc-btn-sm">Apply</button>
            @endif
        </form>
    </div>
    <div>
        <span class="apc-badge apc-badge-light">
            <i class="bi bi-receipt"></i> {{ $orderCount }} Order
        </span>
        <span class="apc-badge apc-badge-success">
            <i class="bi bi-check-circle"></i> {{ $completedCount }} Selesai
        </span>
    </div>
</div>

{{-- Main KPI Grid --}}
<div class="apc-info-row">
    <div class="apc-kpi-card yellow">
        <div class="apc-kpi-icon yellow">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="apc-kpi-label">Omset</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($omzet) }}</div>
        <div class="apc-progress-mini">
            <div class="apc-progress-mini-bar" style="width: 100%; background: var(--apc-yellow);"></div>
        </div>
    </div>

    <div class="apc-kpi-card green">
        <div class="apc-kpi-icon green">
            <i class="bi bi-arrow-down-circle"></i>
        </div>
        <div class="apc-kpi-label">Uang Masuk</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($paymentIn) }}</div>
        <div class="apc-kpi-change positive">
            <i class="bi bi-check2"></i> {{ $paymentRatio }}% dari omset
        </div>
    </div>

    <div class="apc-kpi-card red">
        <div class="apc-kpi-icon red">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="apc-kpi-label">Piutang</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($piutang) }}</div>
        <div class="apc-kpi-change neutral">
            <i class="bi bi-clock"></i> Belum dibayar
        </div>
    </div>

    <div class="apc-kpi-card gray">
        <div class="apc-kpi-icon gray">
            <i class="bi bi-wallet2"></i>
        </div>
        <div class="apc-kpi-label">Pengeluaran</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($expenseIn) }}</div>
        <div class="apc-progress-mini">
            <div class="apc-progress-mini-bar" style="width: {{ $omzet > 0 ? min(($expenseIn / $omzet) * 100, 100) : 0 }}%; background: var(--apc-gray-400);"></div>
        </div>
    </div>

    <div class="apc-kpi-card blue">
        <div class="apc-kpi-icon blue">
            <i class="bi bi-graph-up"></i>
        </div>
        <div class="apc-kpi-label">Gross Profit</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($grossProfit) }}</div>
        <div class="apc-progress-mini">
            <div class="apc-progress-mini-bar" style="width: {{ $omzet > 0 ? min(($grossProfit / $omzet) * 100, 100) : 0 }}%; background: var(--apc-info);"></div>
        </div>
    </div>

    <div class="apc-kpi-card green">
        <div class="apc-kpi-icon green">
            <i class="bi bi-piggy-bank"></i>
        </div>
        <div class="apc-kpi-label">Net Profit</div>
        <div class="apc-kpi-value">{{ \App\Services\Formatter::money($netProfit) }}</div>
        <div class="apc-kpi-change {{ $profitMargin >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-{{ $profitMargin >= 0 ? 'trending-up' : 'trending-down' }}"></i> {{ $profitMargin }}% margin
        </div>
    </div>
</div>

{{-- Alerts & Production Row --}}
<div class="row g-3 mb-4">
    {{-- Overdue Orders --}}
    <div class="col-12 col-lg-6">
        <div class="apc-alert-card h-100">
            <div class="apc-alert-card-header">
                <h2>
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Order Terlambat
                </h2>
                @if($overdueOrders->count() > 0)
                    <span class="badge bg-danger">{{ $overdueOrders->count() }}</span>
                @endif
            </div>
            <div class="apc-alert-card-body">
                @forelse($overdueOrders as $order)
                    <div class="apc-alert-item">
                        <div class="apc-alert-icon danger">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        <div class="apc-alert-info">
                            <strong>{{ $order->order_number }}</strong>
                            <span>{{ $order->customer->name ?? '-' }} · Deadline: {{ \App\Services\Formatter::dateId($order->deadline) }}</span>
                        </div>
                        <div class="apc-alert-action">
                            <a href="{{ route('admin.orders.show', $order) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="apc-empty-state">
                        <i class="bi bi-check-circle"></i>
                        <p>Tidak ada order terlambat</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Deadline Near --}}
    <div class="col-12 col-lg-6">
        <div class="apc-alert-card h-100">
            <div class="apc-alert-card-header">
                <h2>
                    <i class="bi bi-clock-history text-warning"></i>
                    Deadline Mendekat
                </h2>
                @if($deadlineNear->count() > 0)
                    <span class="badge bg-warning text-dark">{{ $deadlineNear->count() }}</span>
                @endif
            </div>
            <div class="apc-alert-card-body">
                @forelse($deadlineNear as $order)
                    <div class="apc-alert-item">
                        <div class="apc-alert-icon warning">
                            <i class="bi bi-hourglass"></i>
                        </div>
                        <div class="apc-alert-info">
                            <strong>{{ $order->order_number }}</strong>
                            <span>{{ $order->customer->name ?? '-' }} · {{ \App\Services\Formatter::dateId($order->deadline) }}</span>
                        </div>
                        <div class="apc-alert-action">
                            <a href="{{ route('admin.orders.show', $order) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="apc-empty-state">
                        <i class="bi bi-calendar-check"></i>
                        <p>Tidak ada deadline dalam 3 hari</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Production Stages --}}
<div class="apc-dash-section-head">
    <h2>
        <i class="bi bi-diagram-3"></i>
        Alur Produksi
    </h2>
    <span class="apc-badge apc-badge-dark">{{ $productionTotal }} order aktif</span>
</div>
<div class="row g-3 mb-4">
    @foreach($productionStages as $stage)
        <div class="col-6 col-md-4 col-lg">
            <a href="{{ route('admin.orders.index', ['status' => $stage]) }}" class="apc-stage-card">
                <div class="apc-stage-icon">
                    <i class="bi bi-{{ $stageLabels[$stage]['icon'] }}"></i>
                </div>
                <div class="apc-stage-count">{{ $productionCounts[$stage] ?? 0 }}</div>
                <div class="apc-stage-label">{{ $stageLabels[$stage]['label'] }}</div>
            </a>
        </div>
    @endforeach
</div>

{{-- Orders Need Attention + Recent Activity Row --}}
<div class="row g-3">
    {{-- Needs Attention --}}
    <div class="col-12 col-lg-7">
        <div class="apc-alert-card">
            <div class="apc-alert-card-header">
                <h2>
                    <i class="bi bi-clipboard-check"></i>
                    Perlu Perhatian
                </h2>
                @if($needsAttention->count() > 0)
                    <span class="badge bg-dark">{{ $needsAttention->count() }}</span>
                @endif
                <a href="{{ route('admin.orders.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="apc-alert-card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($needsAttention as $order)
                    <div class="apc-alert-item">
                        <div class="apc-alert-icon {{ $order->isOverdue() ? 'danger' : 'warning' }}">
                            <i class="bi bi-{{ $order->isOverdue() ? 'exclamation-circle' : 'clock' }}"></i>
                        </div>
                        <div class="apc-alert-info">
                            <strong>{{ $order->order_number }}</strong>
                            <span>
                                {{ $order->customer->name ?? '-' }} ·
                                {{ \App\Services\Formatter::money($order->total) }} ·
                                @php $ps = $order->payment_status; @endphp
                                <span class="apc-badge apc-badge-{{ $ps === 'paid' ? 'success' : ($ps === 'partial' ? 'warning' : 'danger') }}" style="font-size: 10px;">
                                    {{ $ps === 'paid' ? 'Lunas' : ($ps === 'partial' ? 'Sebagian' : 'Belum') }}
                                </span>
                            </span>
                        </div>
                        <div class="apc-alert-action">
                            <a href="{{ route('admin.orders.show', $order) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="apc-empty-state">
                        <i class="bi bi-check2-circle"></i>
                        <p>Semua order berjalan lancar! 🎉</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="col-12 col-lg-5">
        <div class="apc-alert-card">
            <div class="apc-alert-card-header">
                <h2>
                    <i class="bi bi-clock-history"></i>
                    Aktivitas Terbaru
                </h2>
                <span class="badge bg-light text-dark">{{ $recentActivity->count() }}</span>
            </div>
            <div class="apc-alert-card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($recentActivity as $activity)
                    <div class="apc-activity-item">
                        <div class="apc-activity-dot
                            @switch($activity->event)
                                @case('order.created') order @break
                                @case('order.status_changed') order @break
                                @case('payment.recorded') payment @break
                                @case('expense.recorded') expense @break
                                @case('auth.login') auth @break
                                @case('auth.logout') auth @break
                            @default order
                            @endswitch
                        "></div>
                        <div class="apc-activity-content">
                            <strong>{{ $activity->user->name ?? 'System' }}</strong>
                            @switch($activity->event)
                                @case('order.created')
                                    <span>membuat order baru</span>
                                    @if(isset($activity->properties['order_number']))
                                        <span class="apc-mono" style="font-size: 11px;">{{ $activity->properties['order_number'] }}</span>
                                    @endif
                                    @break
                                @case('order.status_changed')
                                    <span>mengubah status order</span>
                                    @break
                                @case('payment.recorded')
                                    <span> mencatat pembayaran</span>
                                    @break
                                @case('expense.recorded')
                                    <span>mencatat pengeluaran</span>
                                    @break
                                @case('settings.updated')
                                    <span>mengubah pengaturan</span>
                                    @break
                                @case('auth.login')
                                    <span>login ke sistem</span>
                                    @break
                                @case('auth.logout')
                                    <span>logout dari sistem</span>
                                    @break
                                @default
                                    <span>{{ $activity->event }}</span>
                            @endswitch
                        </div>
                        <div class="apc-activity-time">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="apc-empty-state">
                        <i class="bi bi-clock"></i>
                        <p>Belum ada aktivitas</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
