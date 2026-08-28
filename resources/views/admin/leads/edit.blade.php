@extends('layouts.admin')
@section('title', 'Edit Lead')
@section('content')
<form method="POST" action="{{ route('admin.leads.update', $lead) }}">
    @csrf @method('PUT')
    @include('admin.leads._form', ['customers' => $customers, 'users' => $users])
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection