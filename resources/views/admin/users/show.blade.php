@extends('layouts.admin')
@section('title', 'User: ' . $user->name)

@section('content')
<div class="apc-page-header">
    <div>
        <h1>Detail User</h1>
        <p class="apc-muted mb-0">Informasi akun {{ $user->name }}.</p>
    </div>
    <div class="d-flex gap-2">
        @can('User.manage')
        <a href="{{ route('admin.users.edit', $user) }}" class="apc-btn apc-btn-dark">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endcan
        <a href="{{ route('admin.users.index') }}" class="apc-btn apc-btn-outline-dark">Kembali</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="apc-card">
            <div class="p-4 text-center">
                <div class="apc-avatar apc-avatar-lg mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="apc-muted mb-3">{{ $user->email }}</p>
                @switch($user->role)
                    @case('super_admin')
                        <span class="apc-badge apc-badge-yellow">Super Admin</span>
                    @break
                    @case('admin')
                        <span class="apc-badge apc-badge-dark">Admin</span>
                    @break
                    @case('staff')
                        <span class="apc-badge apc-badge-light">Staff</span>
                    @break
                @endswitch
                @if($user->is_active)
                    <span class="apc-badge apc-badge-success ms-1">Aktif</span>
                @else
                    <span class="apc-badge apc-badge-danger ms-1">Nonaktif</span>
                @endif
            </div>
            <div class="p-4 border-top" style="border-color: var(--apc-border) !important;">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="apc-muted">Terdaftar</td>
                        <td class="text-end">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="apc-muted">Terakhir Login</td>
                        <td class="text-end">
                            @if($user->email_verified_at)
                                {{ $user->email_verified_at->diffForHumans() }}
                            @else
                                <span class="apc-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="apc-card">
            <div class="p-4">
                <h5 class="mb-3">Aktivity Terbaru</h5>
                @forelse($user->createdOrders as $order)
                    <div class="d-flex gap-2 py-2" style="border-bottom: 1px dashed var(--apc-border);">
                        <span class="apc-badge apc-badge-light">
                            <i class="bi bi-receipt"></i> Order
                        </span>
                        <div>
                            <div>{{ $order->order_number }}</div>
                            <div class="apc-muted small">{{ $order->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center apc-muted py-3">
                        <i class="bi bi-clock-history" style="font-size: 24px;"></i>
                        <div class="mt-1">Belum ada aktivitas tercatat.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
