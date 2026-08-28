@php
    $current = Route::currentRouteName();
    $nav = [
        ['route' => 'admin.dashboard',           'label' => 'Dashboard',    'icon' => 'speedometer2'],
        ['route' => 'admin.products.index',      'label' => 'Produk',       'icon' => 'box'],
        ['route' => 'admin.categories.index',    'label' => 'Kategori',     'icon' => 'tags'],
        ['route' => 'admin.portfolio.index',     'label' => 'Portfolio',    'icon' => 'images'],
        ['route' => 'admin.customers.index',     'label' => 'Customer',     'icon' => 'people'],
        ['route' => 'admin.leads.index',         'label' => 'Lead',         'icon' => 'megaphone'],
        ['route' => 'admin.orders.index',        'label' => 'Order',        'icon' => 'receipt'],
        ['route' => 'admin.production.index',    'label' => 'Produksi',     'icon' => 'diagram-3'],
        ['route' => 'admin.payments.index',      'label' => 'Pembayaran',   'icon' => 'cash'],
        ['route' => 'admin.expenses.index',      'label' => 'Pengeluaran',  'icon' => 'wallet2'],
        ['route' => 'admin.invoices.index',      'label' => 'Invoice',      'icon' => 'file-earmark-text'],
        ['route' => 'admin.reports.index',       'label' => 'Laporan',      'icon' => 'bar-chart'],
        ['route' => 'admin.settings.index',      'label' => 'Settings',     'icon' => 'gear'],
    ];
@endphp
<aside class="apc-sidebar d-none d-lg-block">
    <div class="p-3 d-flex align-items-center gap-2 border-bottom border-secondary">
        <img src="{{ asset('images/logo.svg') }}" alt="APC" height="32">
        <div>
            <div class="fw-bold">APC Admin</div>
            <div class="small text-secondary">v1.0</div>
        </div>
    </div>
    <ul class="list-unstyled p-2">
        @foreach($nav as $item)
            <li>
                <a href="{{ route($item['route']) }}"
                   class="{{ $current === $item['route'] || str_starts_with((string)$current, str_replace('.index', '', $item['route'])) ? 'active' : '' }}">
                    <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                </a>
            </li>
        @endforeach
        <li class="mt-3">
            <a href="{{ url('/') }}" target="_blank"><i class="bi bi-globe me-2"></i> Lihat Website</a>
        </li>
    </ul>
</aside>
<div class="offcanvas offcanvas-start bg-dark text-light" tabindex="-1" id="apcSidebar" aria-labelledby="apcSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title" id="apcSidebarLabel">APC Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            @foreach($nav as $item)
                <li>
                    <a href="{{ route($item['route']) }}" class="text-light">
                        <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
