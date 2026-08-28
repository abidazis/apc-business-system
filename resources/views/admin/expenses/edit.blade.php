@extends('layouts.admin')
@section('title', 'Edit Pengeluaran')
@section('content')
<form method="POST" action="{{ route('admin.expenses.update', $expense) }}">
    @csrf @method('PUT')
    @include('admin.expenses._form')
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection