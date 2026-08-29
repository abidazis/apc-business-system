@extends('layouts.admin')
@section('title', 'Buat Invoice')
@section('content')
    <x-admin::page-header title="Buat Invoice">
        <a href="{{ route('admin.invoices.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.invoices.store') }}">
        @csrf
        <div class="apc-card" style="max-width: 700px;">
            <div class="card-body p-3 p-md-4">@include('admin.invoices._form', ['order' => $order, 'orders' => $orders])</div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Buat Invoice</button>
            <a href="{{ route('admin.invoices.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection