@extends('layouts.admin')
@section('title', 'Customer')
@section('content')
    <x-admin::page-header title="Customer" subtitle="Daftar pelanggan APC">
        <a href="{{ route('admin.customers.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, organisasi, phone..." class="apc-input">
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Customer</th><th>Kontak</th><th>Orders</th><th>Total Transaksi</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>
                            <strong>{{ $c->name }}</strong>
                            @if($c->organization)<div class="apc-muted small">{{ $c->organization }}</div>@endif
                        </td>
                        <td class="small">{{ $c->phone ?? '-' }}@if($c->email)<br>{{ $c->email }}@endif</td>
                        <td>{{ $c->orders_count }}</td>
                        <td><strong>{{ \App\Services\Formatter::money($c->orders_sum_total ?? 0) }}</strong></td>
                        <td class="text-end">
                            <a href="{{ route('admin.customers.show', $c) }}" class="apc-btn apc-btn-ghost apc-btn-sm" title="Lihat"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.customers.edit', $c) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.customers.destroy', $c) }}" class="d-inline" data-confirm="Hapus customer ini?">
                                @csrf @method('DELETE')
                                <button class="apc-btn apc-btn-ghost apc-btn-sm" style="color: var(--apc-danger);"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-admin::empty-state icon="people" title="Belum ada customer" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $customers->links() !!}</div>
@endsection