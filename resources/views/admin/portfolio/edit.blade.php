@extends('layouts.admin')
@section('title', 'Edit Portfolio')
@section('content')
    <x-admin::page-header :title="'Edit: ' . $portfolio->title">
        <a href="{{ route('admin.portfolio.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    <form method="POST" action="{{ route('admin.portfolio.update', $portfolio) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.portfolio._form', ['project' => $portfolio, 'products' => $products, 'attached' => $attached])
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.portfolio.show', $portfolio) }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection