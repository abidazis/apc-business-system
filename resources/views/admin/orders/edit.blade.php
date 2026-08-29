@extends('layouts.admin')
@section('title', 'Edit Order')
@section('content')
    <x-admin::page-header :title="'Edit: ' . $order->order_number">
        <a href="{{ route('admin.orders.show', $order) }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.orders.update', $order) }}" id="orderForm">
        @csrf @method('PUT')
        @include('admin.orders._form', ['customers' => $customers])
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.orders.show', $order) }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection