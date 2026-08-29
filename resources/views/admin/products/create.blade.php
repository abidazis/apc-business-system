@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('content')
    <x-admin::page-header title="Tambah Produk" :actions="'<a href=&quot;' . route('admin.products.index') . '&quot; class=&quot;apc-btn apc-btn-ghost apc-btn-sm&quot;><i class=&quot;bi bi-arrow-left&quot;></i> Kembali</a>'" />
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan Produk</button>
            <a href="{{ route('admin.products.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection