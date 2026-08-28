@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('content')
<form method="POST" action="{{ route('admin.expense-categories.store') }}">
    @csrf
    @include('admin.expense-categories._form', ['category' => null])
    <button class="btn apc-brand-bg mt-3">Simpan</button>
</form>
@endsection