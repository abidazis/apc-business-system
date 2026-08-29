@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')
    <x-admin::page-header :title="'Edit: ' . $product->name" :actions="'<a href=&quot;' . route('admin.products.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a>'" />
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.products._form')
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.products.show', $product) }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection