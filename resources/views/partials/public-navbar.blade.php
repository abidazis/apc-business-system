@php
    $businessName = \App\Support\Settings::get('business_name', 'APC');
    $businessShort = \App\Support\Settings::get('business_short', 'APC');
    $currentRoute = request()->route() ? request()->route()->getName() : null;
    $isHomepage = request()->routeIs('public.home');
@endphp
<header class="apc-nav" id="apcNav">
    <div class="apc-container apc-nav-inner">
        <a class="apc-brand" href="{{ url('/') }}" aria-label="{{ $businessShort }} beranda">
            <span class="apc-brand-mark">APC</span>
            <span class="d-none d-sm-inline">{{ $businessShort }}</span>
        </a>

        <nav class="apc-nav-links" aria-label="Primary">
            <a href="{{ $isHomepage ? '#produk' : route('public.products.index') }}" class="{{ str_starts_with((string)$currentRoute, 'public.products') ? 'is-active' : '' }}">Produk</a>
            <a href="{{ $isHomepage ? '#portfolio' : route('public.portfolio.index') }}" class="{{ str_starts_with((string)$currentRoute, 'public.portfolio') ? 'is-active' : '' }}">Portfolio</a>
            <a href="{{ $isHomepage ? '#tentang' : url('/tentang') }}" class="{{ request()->is('tentang') ? 'is-active' : '' }}">Tentang</a>
            <a href="{{ $isHomepage ? '#faq' : url('/faq') }}" class="{{ request()->is('faq') ? 'is-active' : '' }}">FAQ</a>
            <a href="{{ $isHomepage ? '#cara-order' : url('/kontak') }}" class="{{ request()->is('kontak') ? 'is-active' : '' }}">Kontak</a>
        </nav>

        <div class="apc-nav-actions">
            <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-primary d-none d-md-inline-flex">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
            <button class="apc-burger" type="button" id="apcBurger" aria-label="Buka menu" aria-expanded="false">
                <i class="bi bi-list" id="apcBurgerIcon"></i>
            </button>
        </div>
    </div>
</header>

<aside class="apc-drawer" id="apcDrawer" aria-hidden="true">
    <div class="apc-drawer-bg" data-close-drawer></div>
    <div class="apc-drawer-panel" role="dialog" aria-label="Menu navigasi">
        <div class="apc-drawer-head">
            <a class="apc-brand" href="{{ url('/') }}">
                <span class="apc-brand-mark">APC</span>
                <span>{{ $businessShort }}</span>
            </a>
            <button class="apc-burger" type="button" data-close-drawer aria-label="Tutup menu">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <nav class="apc-drawer-body" aria-label="Mobile">
            <a href="{{ $isHomepage ? '#produk' : route('public.products.index') }}" class="{{ str_starts_with((string)$currentRoute, 'public.products') ? 'is-active' : '' }}">Produk</a>
            <a href="{{ $isHomepage ? '#portfolio' : route('public.portfolio.index') }}" class="{{ str_starts_with((string)$currentRoute, 'public.portfolio') ? 'is-active' : '' }}">Portfolio</a>
            <a href="{{ $isHomepage ? '#tentang' : url('/tentang') }}">Tentang</a>
            <a href="{{ $isHomepage ? '#faq' : url('/faq') }}">FAQ</a>
            <a href="{{ $isHomepage ? '#cara-order' : url('/kontak') }}">Kontak</a>
        </nav>
        <div class="apc-drawer-foot">
            <a href="{{ \App\Support\WhatsApp::url(\App\Support\WhatsApp::messageGeneral()) }}" target="_blank" rel="noopener" class="apc-btn apc-btn-wa apc-btn-block apc-btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</aside>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const nav = document.getElementById('apcNav');
    const burger = document.getElementById('apcBurger');
    const drawer = document.getElementById('apcDrawer');
    const icon = document.getElementById('apcBurgerIcon');

    const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    const open = () => {
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        burger.setAttribute('aria-expanded', 'true');
        if (icon) icon.className = 'bi bi-x';
        document.body.style.overflow = 'hidden';
    };
    const close = () => {
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        burger.setAttribute('aria-expanded', 'false');
        if (icon) icon.className = 'bi bi-list';
        document.body.style.overflow = '';
    };
    burger?.addEventListener('click', () => drawer.classList.contains('is-open') ? close() : open());
    drawer.querySelectorAll('[data-close-drawer]').forEach(el => el.addEventListener('click', close));
    drawer.querySelectorAll('.apc-drawer-body a').forEach(a => a.addEventListener('click', close));
});
</script>
@endpush