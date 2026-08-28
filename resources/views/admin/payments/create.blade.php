@extends('layouts.admin')
@section('title', 'Tambah Pembayaran')
@section('content')
<form method="POST" action="{{ route('admin.payments.store') }}">
    @csrf
    @include('admin.payments._form', ['orders' => $orders, 'payment' => null, 'selected' => $selected])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection