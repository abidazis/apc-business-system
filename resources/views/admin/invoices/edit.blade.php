@extends('layouts.admin')
@section('title', 'Edit Invoice')
@section('content')
<form method="POST" action="{{ route('admin.invoices.update', $invoice) }}">
    @csrf @method('PUT')
    @include('admin.invoices._form', ['invoice' => $invoice, 'order' => $invoice->order])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection