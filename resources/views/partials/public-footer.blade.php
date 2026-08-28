@php
    $businessName = \App\Support\Settings::get('business_name');
    $address = \App\Support\Settings::get('address');
    $phone = \App\Support\Settings::get('phone');
    $email = \App\Support\Settings::get('email');
    $instagram = \App\Support\Settings::get('instagram');
    $tiktok = \App\Support\Settings::get('tiktok');
    $footerNote = \App\Support\Settings::get('footer_note');
@endphp
<footer class="bg-dark text-light mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold">{{ \App\Support\Settings::get('business_short', 'APC') }}</h5>
                <p class="text-light-emphasis small mb-2">{{ $businessName }}</p>
                <p class="text-light-emphasis small mb-0">{{ $address }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-uppercase small fw-semibold">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/') }}" class="text-decoration-none text-light-emphasis">Beranda</a></li>
                    <li><a href="{{ route('public.products.index') }}" class="text-decoration-none text-light-emphasis">Produk</a></li>
                    <li><a href="{{ route('public.portfolio.index') }}" class="text-decoration-none text-light-emphasis">Portfolio</a></li>
                    <li><a href="{{ url('/tentang') }}" class="text-decoration-none text-light-emphasis">Tentang</a></li>
                    <li><a href="{{ url('/kontak') }}" class="text-decoration-none text-light-emphasis">Kontak</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-uppercase small fw-semibold">Hubungi Kami</h6>
                <ul class="list-unstyled small text-light-emphasis">
                    @if($phone)<li><i class="bi bi-telephone"></i> {{ $phone }}</li>@endif
                    @if($email)<li><i class="bi bi-envelope"></i> {{ $email }}</li>@endif
                    @if($instagram)
                        <li><i class="bi bi-instagram"></i> <a href="https://instagram.com/{{ $instagram }}" target="_blank" rel="noopener" class="text-decoration-none text-light-emphasis">@ {{ $instagram }}</a></li>
                    @endif
                    @if($tiktok)
                        <li><i class="bi bi-tiktok"></i> <a href="https://tiktok.com/@{{ $tiktok }}" target="_blank" rel="noopener" class="text-decoration-none text-light-emphasis">@ {{ $tiktok }}</a></li>
                    @endif
                </ul>
                <a class="btn apc-btn-wa btn-sm" target="_blank" rel="noopener" href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}">
                    <i class="bi bi-whatsapp"></i> Chat WhatsApp
                </a>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="small text-center text-light-emphasis mb-0">{{ $footerNote }}</p>
    </div>
</footer>
