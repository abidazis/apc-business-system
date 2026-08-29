@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('content')
    <x-admin::page-header title="Edit Kategori"><a href="{{ route('admin.expense-categories.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a></x-admin::page-header>
    <form method="POST" action="{{ route('admin.expense-categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="apc-card" style="max-width: 600px;"><div class="card-body p-3 p-md-4">@include('admin.expense-categories._form')</div></div>
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan</button>
            <a href="{{ route('admin.expense-categories.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
        </div>
    </form>
@endsection