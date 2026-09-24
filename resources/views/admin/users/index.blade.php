@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
<div class="apc-page-header">
    <div>
        <h1>User Management</h1>
        <p class="apc-muted mb-0">Kelola akun user admin sistem.</p>
    </div>
    @can('User.manage')
    <a href="{{ route('admin.users.create') }}" class="apc-btn apc-btn-dark">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
    @endcan
</div>

{{-- Filters --}}
<div class="apc-card mb-3">
    <div class="p-3">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="apc-label">Cari</label>
                <input type="text" name="q" class="apc-input" value="{{ request('q') }}" placeholder="Nama atau email...">
            </div>
            <div class="col-md-2">
                <label class="apc-label">Role</label>
                <select name="role" class="apc-select">
                    <option value="">Semua</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="apc-label">Status</label>
                <select name="is_active" class="apc-select">
                    <option value="">Semua</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="apc-card">
    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="apc-avatar">{{ substr($u->name, 0, 1) }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $u->name }}</div>
                                    <div class="apc-muted small">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @switch($u->role)
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
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="apc-badge apc-badge-success">Aktif</span>
                            @else
                                <span class="apc-badge apc-badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $u->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.users.show', $u) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('User.manage')
                                <a href="{{ route('admin.users.edit', $u) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-active', $u) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="apc-btn apc-btn-outline-dark apc-btn-sm" title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi bi-{{ $u->is_active ? 'x-circle' : 'check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus user {{ $u->name }}?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="apc-btn apc-btn-danger apc-btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 apc-muted">
                            <i class="bi bi-people" style="font-size: 32px;"></i>
                            <div class="mt-2">Tidak ada user ditemukan.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-3 border-top">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
