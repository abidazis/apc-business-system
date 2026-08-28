@extends('layouts.admin')
@section('title', 'Invoice')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Invoice</h4>
</div>
<form method="get" class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor invoice / customer..." class="form-control"></div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">— Semua Status —</option>
            @foreach(\App\Models\Invoice::STATUSES as $k => $v)
                <option value="{{ $k }}" {{ request('status') === $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Invoice</th><th>Order</th><th>Customer</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($invoices as $i)
                    <tr>
                        <td><strong>{{ $i->invoice_number }}</strong></td>
                        <td><a href="{{ route('admin.orders.show', $i->order) }}">{{ $i->order->order_number ?? '-' }}</a></td>
                        <td>{{ $i->customer->name ?? '-' }}</td>
                        <td>{{ \App\Services\Formatter::dateId($i->issue_date) }}</td>
                        <td>{{ \App\Services\Formatter::money($i->total) }}</td>
                        <td><span class="badge text-bg-{{ $i->status === 'paid' ? 'success' : ($i->status === 'partial' ? 'warning' : 'danger') }}">{{ \App\Models\Invoice::STATUSES[$i->status] ?? $i->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.invoices.show', $i) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                            <a href="{{ route('admin.invoices.pdf', $i) }}" target="_blank" class="btn btn-sm btn-outline-secondary">PDF</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada invoice.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $invoices->links() }}</div>
</div>
@endsection