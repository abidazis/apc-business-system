@extends('layouts.admin')
@section('title', 'Edit Pembayaran')
@section('content')
<form method="POST" action="{{ route('admin.payments.update', $payment) }}">
    @csrf @method('PUT')
    @include('admin.payments._form', ['orders' => $orders, 'payment' => $payment, 'selected' => $payment->order])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection