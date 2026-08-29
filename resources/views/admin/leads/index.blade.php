@extends('layouts.admin')
@section('title', 'Leads')
@section('content')
    <x-admin::page-header title="Leads" subtitle="Prospek calon customer">
        <a href="{{ route('admin.leads.create') }}" class="apc-btn apc-btn-primary apc-btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
    </x-admin::page-header>

    <form method="get" class="apc-toolbar">
        <div class="row g-2">
            <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="apc-input" placeholder="Cari nama / organisasi / phone..."></div>
            <div class="col-md-4">
                <select name="status" class="apc-select">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Lead::STATUSES as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-grid"><button class="apc-btn apc-btn-dark apc-btn-sm">Filter</button></div>
        </div>
    </form>

    <div class="apc-table-wrap">
        <table class="apc-table">
            <thead><tr><th>Kontak</th><th>Organisasi</th><th>Sumber</th><th>Estimasi</th><th>Status</th><th>Follow Up</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($leads as $l)
                    <tr>
                        <td><strong>{{ $l->contact_name }}</strong>@if($l->phone)<div class="apc-muted small">{{ $l->phone }}</div>@endif</td>
                        <td>{{ $l->organization ?? '-' }}</td>
                        <td><span class="apc-badge apc-badge-light">{{ $l->source ?? '-' }}</span></td>
                        <td>{{ $l->estimated_value ? \App\Services\Formatter::money($l->estimated_value) : '-' }}</td>
                        <td>
                            @php $status = $l->status; @endphp
                            <span class="apc-badge apc-badge-{{ $status === 'won' ? 'success' : ($status === 'lost' ? 'danger' : 'light') }}">{{ ucfirst($status) }}</span>
                        </td>
                        <td class="small">{{ $l->follow_up_date ? \App\Services\Formatter::dateId($l->follow_up_date) : '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.leads.show', $l) }}" class="apc-btn apc-btn-ghost apc-btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.leads.edit', $l) }}" class="apc-btn apc-btn-outline-dark apc-btn-sm">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-admin::empty-state icon="megaphone" title="Belum ada lead" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{!! $leads->links() !!}</div>
@endsection