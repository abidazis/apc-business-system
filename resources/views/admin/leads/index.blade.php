@extends('layouts.admin')
@section('title', 'Lead')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Lead</h4>
    <a href="{{ route('admin.leads.create') }}" class="btn apc-brand-bg"><i class="bi bi-plus"></i> Tambah</a>
</div>
<form method="get" class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / organisasi / phone..." class="form-control"></div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">— Semua Status —</option>
            @foreach(\App\Models\Lead::STATUSES as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary">Filter</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Kontak</th><th>Organisasi</th><th>Sumber</th><th>Estimasi</th><th>Status</th><th>Follow Up</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($leads as $l)
                    <tr>
                        <td><strong>{{ $l->contact_name }}</strong><br><small class="text-muted">{{ $l->phone ?? '-' }}</small></td>
                        <td>{{ $l->organization ?? '-' }}</td>
                        <td><span class="badge text-bg-light">{{ $l->source ?? '-' }}</span></td>
                        <td>{{ $l->estimated_value ? \App\Services\Formatter::money($l->estimated_value) : '-' }}</td>
                        <td><span class="badge text-bg-{{ $l->status === 'won' ? 'success' : ($l->status === 'lost' ? 'danger' : 'secondary') }}">{{ ucfirst($l->status) }}</span></td>
                        <td>{{ $l->follow_up_date ? \App\Services\Formatter::dateId($l->follow_up_date) : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.leads.show', $l) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                            <a href="{{ route('admin.leads.edit', $l) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada lead.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $leads->links() }}</div>
</div>
@endsection