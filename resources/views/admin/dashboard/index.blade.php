@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h4 class="fw-bold mb-0">Dashboard Operasional</h4>
    <form method="get" class="d-flex gap-2">
        <select name="preset" class="form-select form-select-sm" onchange="this.form.submit()">
            @foreach(['today' => 'Hari Ini', 'this_week' => 'Minggu Ini', 'this_month' => 'Bulan Ini', 'this_year' => 'Tahun Ini'] as $k => $v)
                <option value="{{ $k }}" {{ $preset === $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
        @if($preset === 'custom')
            <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="form-control form-control-sm">
            <input type="date" name="end" value="{{ $end->format('Y-m-d') }}" class="form-control form-control-sm">
            <button class="btn btn-sm btn-primary">Apply</button>
        @endif
        <a href="{{ route('admin.dashboard', ['preset' => 'custom', 'start' => $start->format('Y-m-d'), 'end' => $end->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary">Custom</a>
    </form>
</div>

<div class="row g-3 mb-4">
    @php
        $stats = [
            ['label' => 'Omset (' . $preset . ')', 'value' => \App\Services\Formatter::money($omzet), 'icon' => 'cash-stack', 'color' => 'primary'],
            ['label' => 'Uang Masuk', 'value' => \App\Services\Formatter::money($paymentIn), 'icon' => 'arrow-down-circle', 'color' => 'success'],
            ['label' => 'Piutang', 'value' => \App\Services\Formatter::money($piutang), 'icon' => 'hourglass-split', 'color' => 'warning'],
            ['label' => 'HPP', 'value' => \App\Services\Formatter::money($hpp), 'icon' => 'box-seam', 'color' => 'secondary'],
            ['label' => 'Pengeluaran', 'value' => \App\Services\Formatter::money($expenseIn), 'icon' => 'wallet2', 'color' => 'danger'],
            ['label' => 'Gross Profit', 'value' => \App\Services\Formatter::money($grossProfit), 'icon' => 'graph-up', 'color' => 'info'],
            ['label' => 'Net Profit', 'value' => \App\Services\Formatter::money($netProfit), 'icon' => 'piggy-bank', 'color' => 'success'],
            ['label' => 'Order Aktif', 'value' => $orderCount, 'icon' => 'receipt', 'color' => 'primary'],
        ];
    @endphp
    @foreach($stats as $s)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="apc-stat h-100">
                <div class="apc-stat-label"><i class="bi bi-{{ $s['icon'] }} me-1 text-{{ $s['color'] }}"></i> {{ $s['label'] }}</div>
                <div class="apc-stat-value">{{ $s['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold">Order yang Perlu Perhatian</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Deadline</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Status Bayar</th>
                    <th>Action</th>
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
                            @else -
                            @endif
                        </td>
                        <td>{{ \App\Services\Formatter::money($o->total) }}</td>
                        <td><span class="badge text-bg-secondary">{{ \App\Models\Order::STATUSES[$o->status] ?? $o->status }}</span></td>
                        <td>
                            @php $ps = $o->payment_status; @endphp
                            <span class="badge text-bg-{{ $ps === 'paid' ? 'success' : ($ps === 'partial' ? 'warning' : 'danger') }}">
                                {{ $ps === 'paid' ? 'Lunas' : ($ps === 'partial' ? 'Sebagian' : 'Belum') }}
                            </span>
                        </td>
                        <td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada order yang perlu perhatian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection