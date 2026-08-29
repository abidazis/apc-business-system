@extends('layouts.admin')
@section('title', 'Tambah Halaman')
@section('content')
    <x-admin::page-header title="Tambah Halaman"><a href="{{ route('admin.pages.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a></x-admin::page-header>
    @include('admin.pages._form', ['page' => null])
@endsection