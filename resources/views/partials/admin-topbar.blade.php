<header class="apc-topbar">
    <div class="d-flex align-items-center gap-2">
        <button class="apc-btn apc-btn-ghost apc-btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#apcSidebarOffcanvas" aria-label="Buka menu">
            <i class="bi bi-list" style="font-size:20px;"></i>
        </button>
        <h1 class="apc-topbar-title d-none d-md-block">{{ $topbarTitle ?? 'Dashboard' }}</h1>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ url('/') }}" target="_blank" class="apc-btn apc-btn-ghost apc-btn-sm d-none d-md-inline-flex" title="Lihat website">
            <i class="bi bi-globe"></i>
        </a>
        <div class="text-end d-none d-sm-block" style="line-height:1.1;">
            <div style="font-size:13px; font-weight:600; color:var(--apc-ink);">{{ auth()->user()?->name }}</div>
            <div style="font-size:11px; color:var(--apc-text-muted); text-transform:uppercase; letter-spacing:0.04em;">{{ auth()->user()?->role }}</div>
        </div>
        <span class="apc-badge apc-badge-dark d-sm-none">{{ strtoupper(substr((string) auth()->user()?->role, 0, 3)) }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="apc-btn apc-btn-outline-dark apc-btn-sm" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-md-inline">Logout</span>
            </button>
        </form>
    </div>
</header>