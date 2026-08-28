@extends('layouts.admin')
@section('title', $invoice->invoice_number)
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">{{ $invoice->invoice_number }}</h4>
        <small class="text-muted">Order: <a href="{{ route('admin.orders.show', $invoice->order) }}">{{ $invoice->order->order_number }}</a></small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-file-pdf"></i> Download PDF</a>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-outline-secondary">Edit</a>
    </div>
</div>

@php
    $order = $invoice->order;
    $payments = $order->payments;
    $paid = (float) $payments->sum('amount');
    $outstanding = max(0, (float) $invoice->total - $paid);
@endphp

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Total Invoice</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($invoice->total) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Terbayar</div><div class="apc-stat-value text-success">{{ \App\Services\Formatter::money($paid) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value text-danger">{{ \App\Services\Formatter::money($outstanding) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Status</div><div class="apc-stat-value">{{ \App\Models\Invoice::STATUSES[$invoice->status] ?? $invoice->status }}</div></div></div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Customer:</strong><br>
                {{ $invoice->customer->name }}<br>
                {{ $invoice->customer->organization }}<br>
                {{ $invoice->customer->phone }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Tanggal:</strong> {{ \App\Services\Formatter::dateId($invoice->issue_date) }}<br>
                @if($invoice->due_date)<strong>Jatuh Tempo:</strong> {{ \App\Services\Formatter::dateId($invoice->due_date) }}@endif
            </div>
        </div>
        <table class="table mt-3">
            <thead class="table-light"><tr><th>Deskripsi</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
            <tbody>
                @foreach($order->items as $it)
                    <tr>
                        <td>{{ $it->description }}</td>
                        <td>{{ $it->quantity }}</td>
                        <td>{{ \App\Services\Formatter::money($it->unit_price) }}</td>
                        <td>{{ \App\Services\Formatter::money($it->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="text-end">Subtotal</th><th>{{ \App\Services\Formatter::money($invoice->subtotal) }}</th></tr>
                <tr><th colspan="3" class="text-end">Discount</th><th>{{ \App\Services\Formatter::money($invoice->discount) }}</th></tr>
                <tr><th colspan="3" class="text-end">Shipping</th><th>{{ \App\Services\Formatter::money($invoice->shipping_cost) }}</th></tr>
                <tr><th colspan="3" class="text-end h5">TOTAL</th><th class="h5">{{ \App\Services\Formatter::money($invoice->total) }}</th></tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection