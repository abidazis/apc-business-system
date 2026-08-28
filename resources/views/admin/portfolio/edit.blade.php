@extends('layouts.admin')
@section('title', 'Edit Portfolio')
@section('content')
<form method="POST" action="{{ route('admin.portfolio.update', $portfolio) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.portfolio._form', ['project' => $portfolio, 'products' => $products, 'attached' => $attached])
    <button class="btn apc-brand-bg mt-3">Simpan</button>
</form>
@endsection