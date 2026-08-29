@extends('layouts.admin')
@section('title', $invoice->invoice_number)
@section('content')
    <x-admin::page-header :title="$invoice->invoice_number" :subtitle="$invoice->customer->name ?? ''">
        <a href="{{ route('admin.invoices.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-file-pdf"></i> Download PDF</a>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
    </x-admin::page-header>

    @php
        $order = $invoice->order;
        $payments = $order->payments;
        $paid = (float) $payments->sum('amount');
        $outstanding = max(0, (float) $invoice->total - $paid);
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3"><div class="apc-stat"><div class="apc-stat-label">Total</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($invoice->total) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat"><div class="apc-stat-label">Terbayar</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($paid) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat apc-stat-accent"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($outstanding) }}</div></div></div>
        <div class="col-6 col-md-3"><div class="apc-stat"><div class="apc-stat-label">Status</div><div class="apc-stat-value">{{ \App\Models\Invoice::STATUSES[$invoice->status] ?? $invoice->status }}</div></div></div>
    </div>

    <div class="apc-card">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <strong>Customer:</strong><br>
                    {{ $invoice->customer->name }}@if($invoice->customer->organization)<br>{{ $invoice->customer->organization }}@endif<br>
                    @if($invoice->customer->phone){{ $invoice->customer->phone }}<br>@endif
                    @if($invoice->customer->address){!! nl2br(e($invoice->customer->address)) !!}@endif
                </div>
                <div class="col-md-6 text-md-end">
                    <strong>Tanggal:</strong> {{ \App\Services\Formatter::dateId($invoice->issue_date) }}<br>
                    @if($invoice->due_date)<strong>Jatuh Tempo:</strong> {{ \App\Services\Formatter::dateId($invoice->due_date) }}@endif
                </div>
            </div>
            <div class="apc-table-wrap">
                <table class="apc-table">
                    <thead><tr><th>Deskripsi</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $it)
                            <tr><td>{{ $it->description }}</td><td>{{ $it->quantity }}</td><td>{{ \App\Services\Formatter::money($it->unit_price) }}</td><td>{{ \App\Services\Formatter::money($it->subtotal) }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><th colspan="3" class="text-end">Subtotal</th><th>{{ \App\Services\Formatter::money($invoice->subtotal) }}</th></tr>
                        <tr><th colspan="3" class="text-end">Discount</th><th>{{ \App\Services\Formatter::money($invoice->discount) }}</th></tr>
                        <tr><th colspan="3" class="text-end">Shipping</th><th>{{ \App\Services\Formatter::money($invoice->shipping_cost) }}</th></tr>
                        <tr><th colspan="3" class="text-end h5">TOTAL</th><th><span class="h5">{{ \App\Services\Formatter::money($invoice->total) }}</span></th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection