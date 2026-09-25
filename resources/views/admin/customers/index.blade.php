@extends('layouts.admin')
@section('title', 'Customer')
@section('content')
    <x-admin::page-header title="Customer" subtitle="Daftar pelanggan APC">
        <a href="{{ route('admin.customers.create') }}" class="apc-btn apc-btn-primary apc-btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah
        </a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2 w-100">
            <div class="col-md-5">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, organisasi, phone..." class="apc-input">
            </div>
            <div class="col-md-3">
                <button type="submit" class="apc-btn apc-btn-dark apc-btn-sm">Cari</button>
                <a href="{{ route('admin.customers.index') }}" class="apc-btn apc-btn-ghost apc-btn-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="apc-card">
        <div class="apc-table-wrap">
            <table class="apc-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Kontak</th>
                        <th>Orders</th>
                        <th>Total Transaksi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td>
                                <strong>{{ $c->name }}</strong>
                                @if($c->organization)
                                    <div class="apc-muted small">{{ $c->organization }}</div>
                                @endif
                            </td>
                            <td class="small">
                                {{ $c->phone ?? '-' }}@if($c->email)<br><span class="apc-muted">{{ $c->email }}</span>@endif
                            </td>
                            <td>{{ $c->orders_count }}</td>
                            <td><strong>{{ \App\Services\Formatter::money($c->orders_sum_total ?? 0) }}</strong></td>
                            <td class="text-end">
                                <a href="{{ route('admin.customers.show', $c) }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.customers.edit', $c) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);" onclick="return confirm('Yakin hapus customer ini?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 apc-muted">
                                <i class="bi bi-people" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                                <div>Belum ada customer.</div>
                                <div class="mt-2">
                                    <a href="{{ route('admin.customers.create') }}" class="apc-btn apc-btn-primary apc-btn-sm">
                                        <i class="bi bi-plus-lg"></i> Tambah Customer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="p-3 border-top" style="border-color: var(--apc-border);">
            {!! $customers->withQueryString()->links() !!}
        </div>
        @endif
    </div>
@endsection
