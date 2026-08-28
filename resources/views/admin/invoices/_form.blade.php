@php $inv = $invoice ?? null; $selectedOrder = $order ?? $inv?->order; @endphp
<div class="card"><div class="card-body">
    @if($selectedOrder && !$inv)
        <div class="alert alert-info small">
            <strong>Order:</strong> {{ $selectedOrder->order_number }} — {{ $selectedOrder->customer->name }}<br>
            Total: {{ \App\Services\Formatter::money($selectedOrder->total) }} (Outstanding: {{ \App\Services\Formatter::money($selectedOrder->outstanding) }})
        </div>
    @endif
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Order <span class="text-danger">*</span></label>
            <select name="order_id" class="form-select" required {{ $inv ? 'disabled' : '' }}>
                <option value="">— Pilih Order —</option>
                @foreach($orders ?? [] as $o)
                    <option value="{{ $o->id }}" {{ old('order_id', $inv?->order_id ?? $selectedOrder?->id) == $o->id ? 'selected' : '' }}>{{ $o->order_number }} — {{ $o->customer->name ?? '-' }} — {{ \App\Services\Formatter::money($o->total) }}</option>
                @endforeach
            </select>
            @if($inv)<small class="text-muted">Order tidak dapat diubah setelah invoice dibuat.</small>@endif
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="issue_date" value="{{ old('issue_date', $inv?->issue_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Jatuh Tempo</label>
            <input type="date" name="due_date" value="{{ old('due_date', $inv?->due_date?->format('Y-m-d')) }}" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $inv?->notes) }}</textarea>
        </div>
    </div>
</div></div>