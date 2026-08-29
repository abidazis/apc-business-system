@extends('layouts.admin')
@section('title', 'Detail Lead')
@section('content')
    <x-admin::page-header :title="$lead->contact_name" :actions="'<a href=&quot;' . route('admin.leads.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a> <a href=&quot;' . route('admin.leads.edit', $lead) . '&quot; class=&quot;apc-btn apc-btn-primary apc-btn-sm&quot;><i class=&quot;bi bi-pencil&quot;></i> Edit</a>'" />
    <div class="apc-card">
        <div class="card-body p-3 p-md-4">
            <table class="apc-table" style="background: transparent;">
                <tr><th style="width:160px;">Nama Kontak</th><td>{{ $lead->contact_name }}</td></tr>
                <tr><th>Organisasi</th><td>{{ $lead->organization ?: '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $lead->phone ?: '-' }}</td></tr>
                <tr><th>Email</th><td>{{ $lead->email ?: '-' }}</td></tr>
                <tr><th>Sumber</th><td>{{ $lead->source ?: '-' }}</td></tr>
                <tr><th>Estimasi</th><td>{{ $lead->estimated_value ? \App\Services\Formatter::money($lead->estimated_value) : '-' }}</td></tr>
                <tr><th>Status</th><td><span class="apc-badge apc-badge-light">{{ ucfirst($lead->status) }}</span></td></tr>
                <tr><th>Follow Up</th><td>{{ $lead->follow_up_date ? \App\Services\Formatter::dateId($lead->follow_up_date) : '-' }}</td></tr>
                <tr><th>Customer</th><td>{{ $lead->customer->name ?? '-' }}</td></tr>
                <tr><th>Ditugaskan</th><td>{{ $lead->assignee->name ?? '-' }}</td></tr>
                <tr><th>Catatan</th><td>{!! nl2br(e($lead->notes ?: '-')) !!}</td></tr>
            </table>
        </div>
    </div>
@endsection