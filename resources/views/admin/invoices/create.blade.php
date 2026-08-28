@extends('layouts.admin')
@section('title', 'Buat Invoice')
@section('content')
<form method="POST" action="{{ route('admin.invoices.store') }}">
    @csrf
    @include('admin.invoices._form', ['order' => $order, 'orders' => $orders])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Buat Invoice</button>
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection