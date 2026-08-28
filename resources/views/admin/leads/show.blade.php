@extends('layouts.admin')
@section('title', 'Detail Lead')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-sm">
            <tr><th width="160">Nama Kontak</th><td>{{ $lead->contact_name }}</td></tr>
            <tr><th>Organisasi</th><td>{{ $lead->organization ?: '-' }}</td></tr>
            <tr><th>Telepon</th><td>{{ $lead->phone ?: '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $lead->email ?: '-' }}</td></tr>
            <tr><th>Sumber</th><td>{{ $lead->source ?: '-' }}</td></tr>
            <tr><th>Estimasi</th><td>{{ $lead->estimated_value ? \App\Services\Formatter::money($lead->estimated_value) : '-' }}</td></tr>
            <tr><th>Status</th><td><span class="badge text-bg-secondary">{{ ucfirst($lead->status) }}</span></td></tr>
            <tr><th>Follow Up</th><td>{{ $lead->follow_up_date ? \App\Services\Formatter::dateId($lead->follow_up_date) : '-' }}</td></tr>
            <tr><th>Customer</th><td>{{ $lead->customer->name ?? '-' }}</td></tr>
            <tr><th>Ditugaskan ke</th><td>{{ $lead->assignee->name ?? '-' }}</td></tr>
            <tr><th>Catatan</th><td>{!! nl2br(e($lead->notes ?: '-')) !!}</td></tr>
        </table>
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('admin.leads.edit', $lead) }}" class="btn apc-brand-bg">Edit</a>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection