@extends('layouts.admin')
@section('title', 'Edit User: ' . $user->name)

@can('User.manage')
@section('content')
<div class="apc-page-header">
    <div>
        <h1>Edit User</h1>
        <p class="apc-muted mb-0">Edit data user {{ $user->name }}.</p>
    </div>
</div>

<div class="apc-card">
    <div class="p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="post">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="apc-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="apc-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="apc-label">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="apc-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password" class="apc-label">Password Baru</label>
                    <input type="password" id="password" name="password" class="apc-input @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                    <div class="apc-help">Kosongkan jika tidak ingin mengubah password.</div>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="apc-label">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="apc-input">
                </div>
                <div class="col-md-6">
                    <label for="role" class="apc-label">Role <span class="text-danger">*</span></label>
                    <select id="role" name="role" class="apc-select @error('role') is-invalid @enderror" required>
                        <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="apc-label">Status</label>
                    <div class="mt-2">
                        <label class="apc-switch">
                            <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                            <span class="apc-slider"></span>
                        </label>
                        <span class="ms-2">User aktif</span>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="my-2">
                    <button type="submit" class="apc-btn apc-btn-dark">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="apc-btn apc-btn-outline-dark">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@else
@section('content')
<div class="apc-card">
    <div class="p-5 text-center">
        <i class="bi bi-lock" style="font-size: 48px; color: var(--apc-gray-300);"></i>
        <h3 class="mt-3">Akses Ditolak</h3>
        <p class="apc-muted">Halaman ini hanya dapat diakses oleh Super Admin.</p>
        <a href="{{ route('admin.dashboard') }}" class="apc-btn apc-btn-dark">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
@endcan
