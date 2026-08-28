@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            @include('admin.categories._form')
            <div class="d-flex gap-2 mt-4">
                <button class="btn apc-brand-bg">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection