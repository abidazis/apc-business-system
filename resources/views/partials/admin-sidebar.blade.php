@php
    $current = Route::currentRouteName();
    $bizShort = \App\Support\Settings::get('business_short', 'APC');
    $nav = [
        ['route' => 'admin.dashboard',           'label' => 'Dashboard',     'icon' => 'speedometer2', 'group' => 'Utama'],
        ['route' => 'admin.orders.index',       'label' => 'Orders',        'icon' => 'receipt', 'group' => 'Operasional'],
        ['route' => 'admin.production.index',   'label' => 'Production',    'icon' => 'diagram-3', 'group' => 'Operasional'],
        ['route' => 'admin.customers.index',    'label' => 'Customers',     'icon' => 'people', 'group' => 'Operasional'],
        ['route' => 'admin.leads.index',        'label' => 'Leads',         'icon' => 'megaphone', 'group' => 'Operasional'],
        ['route' => 'admin.products.index',     'label' => 'Products',      'icon' => 'box', 'group' => 'Katalog'],
        ['route' => 'admin.categories.index',   'label' => 'Categories',    'icon' => 'tags', 'group' => 'Katalog'],
        ['route' => 'admin.portfolio.index',    'label' => 'Portfolio',     'icon' => 'images', 'group' => 'Katalog'],
        ['route' => 'admin.invoices.index',     'label' => 'Invoices',      'icon' => 'file-earmark-text', 'group' => 'Keuangan'],
        ['route' => 'admin.payments.index',     'label' => 'Payments',      'icon' => 'cash', 'group' => 'Keuangan'],
        ['route' => 'admin.expenses.index',     'label' => 'Expenses',      'icon' => 'wallet2', 'group' => 'Keuangan'],
        ['route' => 'admin.reports.index',      'label' => 'Reports',       'icon' => 'bar-chart', 'group' => 'Keuangan'],
        ['route' => 'admin.faqs.index',         'label' => 'FAQs',          'icon' => 'question-circle', 'group' => 'Sistem'],
        ['route' => 'admin.pages.index',        'label' => 'Pages',         'icon' => 'file-text', 'group' => 'Sistem'],
        ['route' => 'admin.settings.index',     'label' => 'Settings',      'icon' => 'gear', 'group' => 'Sistem'],
    ];
    $currentGroup = null;
@endphp
<aside class="apc-sidebar">
    <div class="apc-sidebar-brand">
        <span class="mark">APC</span>
        <div>
            <div class="name">{{ $bizShort }}</div>
            <div class="role">Admin Panel</div>
        </div>
    </div>
    <nav class="apc-sidebar-nav">
        @foreach($nav as $item)
            @if($currentGroup !== $item['group'])
                @php $currentGroup = $item['group']; @endphp
                <div class="apc-sidebar-section">{{ $currentGroup }}</div>
            @endif
            <a href="{{ route($item['route']) }}" class="navlink {{ $current === $item['route'] ? 'is-active' : '' }}">
                <i class="bi bi-{{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>

{{-- Mobile sidebar (offcanvas) --}}
<div class="offcanvas offcanvas-start bg-dark text-light" tabindex="-1" id="apcSidebarOffcanvas" aria-labelledby="apcSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title" id="apcSidebarLabel">{{ $bizShort }} Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @foreach($nav as $item)
            <a href="{{ route($item['route']) }}" class="navlink d-flex align-items-center gap-2 py-2 text-light {{ $current === $item['route'] ? 'is-active' : '' }}" style="color:inherit; padding: 10px 12px; border-radius: 8px;">
                <i class="bi bi-{{ $item['icon'] }}"></i> {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</div>