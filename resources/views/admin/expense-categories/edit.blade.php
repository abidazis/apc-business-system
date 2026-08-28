@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('content')
<form method="POST" action="{{ route('admin.expense-categories.update', $category) }}">
    @csrf @method('PUT')
    @include('admin.expense-categories._form', ['category' => $category])
    <button class="btn apc-brand-bg mt-3">Simpan</button>
</form>
@endsection