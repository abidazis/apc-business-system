@extends('layouts.admin')
@section('title', 'Tambah User')

@can('User.manage')
@section('content')
<div class="apc-page-header">
    <div>
        <h1>Tambah User</h1>
        <p class="apc-muted mb-0">Buat akun user baru untuk akses admin.</p>
    </div>
</div>

<div class="apc-card">
    <div class="p-4">
        <form action="{{ route('admin.users.store') }}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="apc-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="apc-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="apc-label">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="apc-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password" class="apc-label">Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" class="apc-input @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                    <div class="apc-help">Minimal 8 karakter.</div>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="apc-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="apc-input" required>
                </div>
                <div class="col-md-6">
                    <label for="role" class="apc-label">Role <span class="text-danger">*</span></label>
                    <select id="role" name="role" class="apc-select @error('role') is-invalid @enderror" required>
                        <option value="">Pilih Role</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <div class="apc-help text-danger">{{ $message }}</div>
                    @enderror
                    <div class="apc-help">
                        <strong>Staff:</strong> Akses terbatas<br>
                        <strong>Admin:</strong> Akses penuh operasi<br>
                        <strong>Super Admin:</strong> Akses penuh + user management
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="apc-label">Status</label>
                    <div class="mt-2">
                        <label class="apc-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="apc-slider"></span>
                        </label>
                        <span class="ms-2">User aktif</span>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="my-2">
                    <button type="submit" class="apc-btn apc-btn-dark">
                        <i class="bi bi-check-lg"></i> Simpan User
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
