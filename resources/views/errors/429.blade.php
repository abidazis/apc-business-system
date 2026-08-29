@extends('layouts.public')
@section('title', 'Terlalu Banyak Permintaan — ' . \App\Support\Settings::get('business_short', 'APC'))

@section('content')
<section class="apc-section" style="min-height:60vh;display:flex;align-items:center;">
    <div class="apc-container text-center">
        <span class="apc-eyebrow">429</span>
        <h1 class="apc-section-title mt-3">Terlalu Banyak Permintaan</h1>
        <p class="apc-section-subtitle" style="margin-left:auto;margin-right:auto;">Mohon tunggu sebentar sebelum mencoba lagi.</p>
    </div>
</section>
@endsection