@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection