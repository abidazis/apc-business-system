@extends('layouts.admin')
@section('title', $order->order_number)
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">{{ $order->order_number }}</h4>
        <small class="text-muted">Dibuat {{ $order->created_at->diffForHumans() }}</small>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageForOrder($order->order_number)) }}" target="_blank" rel="noopener" class="btn btn-sm apc-btn-wa"><i class="bi bi-whatsapp"></i> Chat Customer</a>
        <a href="{{ route('admin.invoices.create', ['order' => $order->id]) }}" class="btn btn-sm btn-outline-primary">Buat Invoice</a>
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Subtotal</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->subtotal) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Total</div><div class="apc-stat-value">{{ \App\Services\Formatter::money($order->total) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Terbayar</div><div class="apc-stat-value text-success">{{ \App\Services\Formatter::money($order->total_paid) }}</div></div></div>
    <div class="col-md-3"><div class="apc-stat"><div class="apc-stat-label">Outstanding</div><div class="apc-stat-value text-danger">{{ \App\Services\Formatter::money($order->outstanding) }}</div></div></div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Informasi</h6>
                <table class="table table-sm">
                    <tr><th width="140">Customer</th><td>{{ $order->customer->name ?? '-' }}</td></tr>
                    <tr><th>Tanggal</th><td>{{ \App\Services\Formatter::dateId($order->order_date) }}</td></tr>
                    <tr><th>Deadline</th><td>{{ $order->deadline ? \App\Services\Formatter::dateId($order->deadline) : '-' }}</td></tr>
                    <tr><th>Status Bayar</th><td>
                        @php $ps = $order->payment_status; @endphp
                        <span class="badge text-bg-{{ $ps === 'paid' ? 'success' : ($ps === 'partial' ? 'warning' : 'danger') }}">{{ $ps === 'paid' ? 'Lunas' : ($ps === 'partial' ? 'Sebagian' : 'Belum') }}</span>
                    </td></tr>
                    <tr><th>Notes</th><td>{!! nl2br(e($order->notes ?: '-')) !!}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Update Status Produksi</h6>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-flex gap-2">
                    @csrf
                    <select name="status" class="form-select">
                        @foreach(\App\Models\Order::STATUSES as $k => $v)
                            <option value="{{ $k }}" {{ $order->status === $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                    <button class="btn apc-brand-bg">Update</button>
                </form>
                <hr>
                <h6 class="fw-bold mb-2">HPP & Profit</h6>
                <table class="table table-sm">
                    <tr><th>HPP Total</th><td>{{ \App\Services\Formatter::money($order->hpp_total) }}</td></tr>
                    <tr><th>Gross Profit</th><td class="fw-bold">{{ \App\Services\Formatter::money($order->gross_profit) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Item</h6></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Deskripsi</th><th>Qty</th><th>Harga</th><th>HPP</th><th>Subtotal</th></tr></thead>
            <tbody>
                @foreach($order->items as $i)
                    <tr>
                        <td>{{ $i->description }}</td>
                        <td>{{ $i->quantity }}</td>
                        <td>{{ \App\Services\Formatter::money($i->unit_price) }}</td>
                        <td>{{ \App\Services\Formatter::money($i->hpp) }}</td>
                        <td>{{ \App\Services\Formatter::money($i->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr><th colspan="4" class="text-end">Subtotal</th><th>{{ \App\Services\Formatter::money($order->subtotal) }}</th></tr>
                <tr><th colspan="4" class="text-end">Discount</th><th>{{ \App\Services\Formatter::money($order->discount) }}</th></tr>
                <tr><th colspan="4" class="text-end">Shipping</th><th>{{ \App\Services\Formatter::money($order->shipping_cost) }}</th></tr>
                <tr><th colspan="4" class="text-end">TOTAL</th><th class="fw-bold">{{ \App\Services\Formatter::money($order->total) }}</th></tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Pembayaran</h6>
        <a href="{{ route('admin.payments.create', ['order' => $order->id]) }}" class="btn btn-sm apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Tanggal</th><th>Metode</th><th>Jumlah</th><th>Ref</th><th>Catatan</th></tr></thead>
            <tbody>
                @forelse($order->payments as $p)
                    <tr>
                        <td>{{ \App\Services\Formatter::dateId($p->payment_date) }}</td>
                        <td>{{ \App\Models\Payment::METHODS[$p->method] ?? $p->method }}</td>
                        <td>{{ \App\Services\Formatter::money($p->amount) }}</td>
                        <td>{{ $p->reference ?: '-' }}</td>
                        <td>{{ $p->notes ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($order->invoice)
<div class="card">
    <div class="card-body">
        <h6 class="fw-bold">Invoice</h6>
        <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="btn btn-outline-primary btn-sm">Lihat Invoice {{ $order->invoice->invoice_number }}</a>
        <a href="{{ route('admin.invoices.pdf', $order->invoice) }}" target="_blank" class="btn btn-outline-secondary btn-sm">Download PDF</a>
    </div>
</div>
@endif

@endsection