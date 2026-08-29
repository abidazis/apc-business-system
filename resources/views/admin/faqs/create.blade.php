@extends('layouts.admin')
@section('title', 'Tambah FAQ')
@section('content')
    <x-admin::page-header title="Tambah FAQ">
        <a href="{{ route('admin.faqs.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    @include('admin.faqs._form', ['faq' => null])
@endsection