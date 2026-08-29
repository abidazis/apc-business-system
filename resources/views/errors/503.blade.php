@extends('layouts.public')
@section('title', 'Halaman Tidak Berfungsi — ' . \App\Support\Settings::get('business_short', 'APC'))

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">503</span>
        <h1 class="apc-section-title mt-3">Sedang Pemeliharaan</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Sistem sedang dalam pemeliharaan singkat. Silakan coba beberapa saat lagi.</p>
    </div>
</section>
@endsection