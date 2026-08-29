@extends('layouts.admin')
@section('title', 'Edit FAQ')
@section('content')
    <x-admin::page-header title="Edit FAQ">
        <a href="{{ route('admin.faqs.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </x-admin::page-header>
    @include('admin.faqs._form', ['faq' => $faq])
@endsection