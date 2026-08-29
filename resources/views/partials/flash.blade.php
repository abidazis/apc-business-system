@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: var(--apc-radius); border: 1px solid rgba(22,163,74,.25); background: rgba(22,163,74,.08); color: #15803D;">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius: var(--apc-radius); border: 1px solid rgba(220,38,38,.25); background: rgba(220,38,38,.08); color: #B91C1C;">
        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert" style="border-radius: var(--apc-radius); border: 1px solid rgba(245,158,11,.3); background: rgba(245,158,11,.08); color: #92400E;">
        <strong><i class="bi bi-exclamation-triangle me-1"></i> Ada kesalahan:</strong>
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif