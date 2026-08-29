@extends('layouts.admin')
@section('title', 'Tambah Portfolio')
@section('content')
    <x-admin::page-header title="Tambah Portfolio">
        <a href="{{ route('admin.portfolio.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.portfolio._form', ['project' => null, 'products' => $products, 'attached' => []])
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.portfolio.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection