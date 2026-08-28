@extends('layouts.admin')
@section('title', 'Production Board')
@section('content')
<h4 class="fw-bold mb-3">Production Board</h4>
<div class="apc-kanban">
    @foreach($columns as $key => $label)
        <div class="apc-kanban-col">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-semibold mb-0">{{ $label }}</h6>
                <span class="badge text-bg-secondary">{{ isset($orders[$key]) ? $orders[$key]->count() : 0 }}</span>
            </div>
            @forelse(($orders[$key] ?? collect()) as $o)
                <div class="apc-kanban-card">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <a href="{{ route('admin.orders.show', $o) }}" class="fw-semibold text-decoration-none text-dark">{{ $o->order_number }}</a>
                        @if($o->isOverdue())
                            <span class="badge text-bg-danger small">Overdue</span>
                        @elseif($o->isDeadlineNear())
                            <span class="badge text-bg-warning small">Segera</span>
                        @endif
                    </div>
                    <small class="text-muted d-block">{{ $o->customer->name ?? '-' }}</small>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">{{ $o->deadline ? \App\Services\Formatter::dateId($o->deadline) : '-' }}</small>
                        <small class="fw-bold">{{ \App\Services\Formatter::money($o->total) }}</small>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted small py-3">— kosong —</div>
            @endforelse
        </div>
    @endforeach
</div>
@endsection