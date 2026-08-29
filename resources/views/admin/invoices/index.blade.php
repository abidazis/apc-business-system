@extends('layouts.admin')
@section('title', 'Invoice')
@section('content')
    <x-admin::page-header title="Invoice" />

    <form method="get" class="apc-toolbar">
        <div class="row g-2">
            <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari nomor invoice / customer..."></div>
            <div class="col-md-3">
                <select name="status" class="apc-select">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Invoice::STATUSES as $k => $v)
                        <option value="{{ $k }}" {{ request('status') === $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Invoice</th><th>Order</th><th>Customer</th><th>Tanggal</th><th>Total</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($invoices as $i)
                    <tr>
                        <td><strong>{{ $i->invoice_number }}</strong></td>
                        <td><a href="{{ route('admin.orders.show', $i->order) }}" style="color: var(--apc-ink); font-weight: 600;">{{ $i->order->order_number ?? '-' }}</a></td>
                        <td>{{ $i->customer->name ?? '-' }}</td>
                        <td>{{ \App\Services\Formatter::dateId($i->issue_date) }}</td>
                        <td><strong>{{ \App\Services\Formatter::money($i->total) }}</strong></td>
                        <td><span class="apc-badge apc-badge-{{ $i->status === 'paid' ? 'success' : ($i->status === 'partial' ? 'warning' : 'danger') }}">{{ \App\Models\Invoice::STATUSES[$i->status] ?? $i->status }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.invoices.show', $i) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Lihat</a>
                            <a href="{{ route('admin.invoices.pdf', $i) }}" target="_blank" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-file-pdf"></i> PDF</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-admin::empty-state icon="file-earmark-text" title="Belum ada invoice" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $invoices->links() !!}</div>
@endsection