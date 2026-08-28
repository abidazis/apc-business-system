@extends('layouts.admin')
@section('title', 'Edit Customer')
@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
            @csrf @method('PUT')
            @include('admin.customers._form')
            <div class="d-flex gap-2 mt-4">
                <button class="btn apc-brand-bg">Simpan</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection