@extends('layouts.admin')
@section('title', 'Tambah Order')
@section('content')
    <x-admin::page-header title="Tambah Order">
        <a href="{{ route('admin.orders.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
        @csrf
        @include('admin.orders._form', ['customers' => $customers, 'leads' => $leads, 'lead' => $lead])
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.orders.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection