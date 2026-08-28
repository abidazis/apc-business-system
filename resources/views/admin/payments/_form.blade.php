@php
    $p = $payment ?? null;
    $selOrder = $selected ?? $p?->order;
@endphp
<div class="card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Order <span class="text-danger">*</span></label>
            <select name="order_id" class="form-select" required>
                <option value="">— Pilih Order —</option>
                @foreach($orders as $o)
                    <option value="{{ $o->id }}" {{ old('order_id', $p?->order_id ?? $selOrder?->id) == $o->id ? 'selected' : '' }}>
                        {{ $o->order_number }} — {{ $o->customer->name ?? '-' }} — Outstanding: {{ \App\Services\Formatter::money($o->outstanding) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="payment_date" value="{{ old('payment_date', $p?->payment_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Metode</label>
            <select name="method" class="form-select">
                @foreach(\App\Models\Payment::METHODS as $k => $v)
                    <option value="{{ $k }}" {{ old('method', $p?->method ?? 'bank_transfer') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
            <input type="number" name="amount" value="{{ old('amount', $p?->amount) }}" class="form-control" min="1" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Referensi</label>
            <input type="text" name="reference" value="{{ old('reference', $p?->reference) }}" class="form-control" placeholder="No. transfer / struk">
        </div>
        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $p?->notes) }}</textarea>
        </div>
    </div>
</div></div>