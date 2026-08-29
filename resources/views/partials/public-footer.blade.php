@php
    $businessName = \App\Support\Settings::get('business_name');
    $address = \App\Support\Settings::get('address');
    $phone = \App\Support\Settings::get('phone');
    $email = \App\Support\Settings::get('email');
    $instagram = \App\Support\Settings::get('instagram');
    $tiktok = \App\Support\Settings::get('tiktok');
    $footerNote = \App\Support\Settings::get('footer_note');
    $bizShort = \App\Support\Settings::get('business_short', 'APC');
    $tagline = \App\Support\Settings::get('tagline');
@endphp
<footer class="apc-footer">
    <div class="apc-container">
        <div class="row g-4">
            <div class="col-md-5">
                <a class="apc-brand" href="{{ url('/') }}" style="color:#fff;">
                    <span class="apc-brand-mark">APC</span>
                    <span>{{ $bizShort }}</span>
                </a>
                <p class="mt-3" style="font-size:14px; max-width: 360px;">{{ $tagline }}</p>
                <p class="small mt-3" style="color: rgba(255,255,255,.55);">{{ $address }}</p>
            </div>
            <div class="col-6 col-md-3">
                <h5>Navigasi</h5>
                <ul>
                    <li><a href="{{ route('public.products.index') }}">Produk</a></li>
                    <li><a href="{{ route('public.portfolio.index') }}">Portfolio</a></li>
                    <li><a href="{{ url('/tentang') }}">Tentang</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    <li><a href="{{ url('/kontak') }}">Kontak</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h5>Hubungi Kami</h5>
                <ul>
                    @if($phone)<li><i class="bi bi-telephone"></i> {{ $phone }}</li>@endif
                    @if($email)<li><i class="bi bi-envelope"></i> {{ $email }}</li>@endif
                    @if($instagram)
                        <li><i class="bi bi-instagram"></i> <a href="https://instagram.com/{{ $instagram }}" target="_blank" rel="noopener">@ {{ $instagram }}</a></li>
                    @endif
                    @if($tiktok)
                        <li><i class="bi bi-tiktok"></i> <a href="https://tiktok.com/@{{ $tiktok }}" target="_blank" rel="noopener">@ {{ $tiktok }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="apc-footer-bottom">
            <span>{{ $footerNote }}</span>
            <span>&copy; {{ date('Y') }} {{ $businessName }}. All rights reserved.</span>
        </div>
    </div>
</footer>