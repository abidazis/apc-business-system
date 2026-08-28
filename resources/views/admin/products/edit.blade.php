@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._form')
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection