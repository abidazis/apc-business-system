@extends('layouts.admin')
@section('title', 'Production Board')
@section('content')
    <x-admin::page-header title="Production Board" subtitle="Visual tracking pesanan berdasarkan status produksi" />
    <div class="apc-kanban">
        @foreach($columns as $key => $label)
            <div class="apc-kanban-col">
                <div class="apc-kanban-col-head">
                    <h6>{{ $label }}</h6>
                    <span class="count">{{ isset($orders[$key]) ? $orders[$key]->count() : 0 }}</span>
                </div>
                @forelse(($orders[$key] ?? collect()) as $o)
                    <a href="{{ route('admin.orders.show', $o) }}" class="apc-kanban-card d-block" style="color: inherit; text-decoration: none;">
                        <h6>{{ $o->order_number }}</h6>
                        <div class="meta">{{ $o->customer->name ?? '-' }}</div>
                        <div class="foot">
                            <span class="meta">{{ $o->deadline ? \App\Services\Formatter::dateId($o->deadline) : '-' }}</span>
                            <span><strong>{{ \App\Services\Formatter::money($o->total) }}</strong></span>
                        </div>
                        @if($o->isOverdue())<span class="apc-badge apc-badge-danger mt-1">Overdue</span>
                        @elseif($o->isDeadlineNear())<span class="apc-badge apc-badge-warning mt-1">Segera</span>@endif
                    </a>
                @empty
                    <div class="text-center apc-muted small py-3">— kosong —</div>
                @endforelse
            </div>
        @endforeach
    </div>
@endsection