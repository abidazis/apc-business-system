@extends('layouts.admin')
@section('title', 'Tambah Order')
@section('content')
<form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
    @csrf
    @include('admin.orders._form', ['customers' => $customers, 'leads' => $leads, 'lead' => $lead])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection