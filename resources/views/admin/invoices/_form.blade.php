@php $inv = $invoice ?? null; $selectedOrder = $order ?? $inv?->order; @endphp
<div class="row g-3">
    @if($selectedOrder && !$inv)
        <div class="col-12"><div class="apc-card" style="background: var(--apc-gray-50); border-style: dashed;"><div class="card-body p-3"><small class="apc-muted"><strong>Order:</strong> {{ $selectedOrder->order_number }} — {{ $selectedOrder->customer->name }}<br>Total: {{ \App\Services\Formatter::money($selectedOrder->total) }} (Outstanding: {{ \App\Services\Formatter::money($selectedOrder->outstanding) }})</small></div></div></div>
    @endif
    <div class="col-md-6 apc-field">
        <label class="apc-label">Order <span class="text-danger">*</span></label>
        <select name="order_id" class="apc-select" required {{ $inv ? 'disabled' : '' }}>
            <option value="">— Pilih Order —</option>
            @foreach($orders ?? [] as $o)
                <option value="{{ $o->id }}" {{ old('order_id', $inv?->order_id ?? $selectedOrder?->id) == $o->id ? 'selected' : '' }}>{{ $o->order_number }} — {{ $o->customer->name ?? '-' }} — {{ \App\Services\Formatter::money($o->total) }}</option>
            @endforeach
        </select>
        @if($inv)<small class="apc-help">Order tidak dapat diubah setelah invoice dibuat.</small>@endif
    </div>
    <div class="col-md-3 apc-field"><label class="apc-label">Tanggal <span class="text-danger">*</span></label><input type="date" name="issue_date" value="{{ old('issue_date', $inv?->issue_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="apc-input" required></div>
    <div class="col-md-3 apc-field"><label class="apc-label">Jatuh Tempo</label><input type="date" name="due_date" value="{{ old('due_date', $inv?->due_date?->format('Y-m-d')) }}" class="apc-input"></div>
    <div class="col-12 apc-field"><label class="apc-label">Catatan</label><textarea name="notes" rows="2" class="apc-textarea">{{ old('notes', $inv?->notes) }}</textarea></div>
</div>