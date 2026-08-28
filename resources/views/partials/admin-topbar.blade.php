<nav class="navbar bg-white border-bottom px-3 px-md-4 sticky-top">
    <div class="container-fluid">
        <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#apcSidebar">
            <i class="bi bi-list"></i>
        </button>
        <span class="ms-2 fw-semibold d-lg-none">APC Admin</span>
        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="small text-muted d-none d-sm-inline">{{ auth()->user()?->name }}</span>
            <span class="badge bg-secondary text-uppercase">{{ auth()->user()?->role }}</span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>
