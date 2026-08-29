@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
    <x-admin::page-header title="Settings" subtitle="Konfigurasi identitas bisnis & sistem" />
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="apc-card">
            <div class="p-3 p-md-4 border-bottom" style="border-color: var(--apc-border) !important;"><h2 style="font-size: 14px; font-weight: 700; margin: 0;">Identitas Bisnis</h2></div>
            <div class="card-body p-3 p-md-4">
                @include('admin.settings._form', ['values' => $values])
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button class="apc-btn apc-btn-primary">Simpan Settings</button>
        </div>
    </form>
@endsection