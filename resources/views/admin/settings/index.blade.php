@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<h4 class="fw-bold mb-3">Settings</h4>
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.settings._form', ['values' => $values])
    <button class="btn apc-brand-bg mt-3">Simpan Settings</button>
</form>
@endsection