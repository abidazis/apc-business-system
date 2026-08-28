@extends('layouts.admin')
@section('title', 'Tambah Portfolio')
@section('content')
<form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.portfolio._form', ['project' => null, 'products' => $products, 'attached' => []])
    <button class="btn apc-brand-bg mt-3">Simpan</button>
</form>
@endsection