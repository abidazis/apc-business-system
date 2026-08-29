@extends('layouts.admin')
@section('title', 'Edit Lead')
@section('content')
    <x-admin::page-header :title="'Edit Lead: ' . $lead->contact_name">
        <a href="{{ route('admin.leads.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
        @csrf @method('PUT')
        <div class="apc-card" style="max-width: 800px;">
            <div class="card-body p-3 p-md-4">@include('admin.leads._form', ['customers' => $customers, 'users' => $users])</div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.leads.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection