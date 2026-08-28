@extends('layouts.admin')
@section('title', 'Edit Order')
@section('content')
<form method="POST" action="{{ route('admin.orders.update', $order) }}" id="orderForm">
    @csrf @method('PUT')
    @include('admin.orders._form', ['customers' => $customers])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection