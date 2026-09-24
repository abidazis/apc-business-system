@extends('layouts.admin')
@section('title', 'Detail Lead')
@section('content')
    <x-admin::page-header :title="$lead->contact_name" :actions="'<a href=&quot;' . route('admin.leads.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a>'" />
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <a href="{{ route('admin.leads.edit', $lead) }}" class="apc-btn apc-btn-primary">
            <i class="bi bi-pencil"></i> Edit Lead
        </a>
        @if($lead->customer_id && $lead->customer)
            <a href="{{ route('admin.customers.show', $lead->customer) }}" class="apc-btn apc-btn-dark">
                <i class="bi bi-person"></i> Lihat Customer
            </a>
        @else
            <form action="{{ route('admin.leads.convert-to-customer', $lead) }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="apc-btn apc-btn-wa" onclick="return confirm('Buat customer dari lead ini?')">
                    <i class="bi bi-person-plus"></i> Convert ke Customer
                </button>
            </form>
        @endif
        @if($lead->status !== 'won' && $lead->status !== 'lost')
            <a href="{{ route('admin.orders.create', ['lead' => $lead->id]) }}" class="apc-btn apc-btn-outline-dark">
                <i class="bi bi-receipt"></i> Buat Order
            </a>
        @endif
    </div>

    <div class="apc-card mb-3">
        <div class="card-body p-3 p-md-4">
            <table class="apc-table" style="background: transparent;">
                <tr><th style="width:160px;">Nama Kontak</th><td>{{ $lead->contact_name }}</td></tr>
                <tr><th>Organisasi</th><td>{{ $lead->organization ?: '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $lead->phone ?: '-' }}</td></tr>
                <tr><th>Email</th><td>{{ $lead->email ?: '-' }}</td></tr>
                <tr><th>Sumber</th><td>{{ $lead->source ?: '-' }}</td></tr>
                <tr><th>Estimasi</th><td>{{ $lead->estimated_value ? \App\Services\Formatter::money($lead->estimated_value) : '-' }}</td></tr>
                <tr><th>Status</th><td>
                    <span class="apc-badge apc-badge-{{ $lead->status === 'won' ? 'success' : ($lead->status === 'lost' ? 'danger' : 'light') }}">
                        {{ ucfirst($lead->status) }}
                    </span>
                </td></tr>
                <tr><th>Follow Up</th><td>{{ $lead->follow_up_date ? \App\Services\Formatter::dateId($lead->follow_up_date) : '-' }}</td></tr>
                <tr><th>Customer</th><td>
                    @if($lead->customer)
                        <a href="{{ route('admin.customers.show', $lead->customer) }}">{{ $lead->customer->name }}</a>
                    @else
                        <span class="apc-muted">Belum ada customer</span>
                    @endif
                </td></tr>
                <tr><th>Ditugaskan</th><td>{{ $lead->assignee->name ?? '-' }}</td></tr>
                <tr><th>Catatan</th><td>{!! nl2br(e($lead->notes ?: '-')) !!}</td></tr>
            </table>
        </div>
    </div>
@endsection