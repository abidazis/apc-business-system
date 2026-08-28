@php $e = $expense ?? null; $categories = $categories ?? collect(); @endphp
<div class="card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="date" value="{{ old('date', $e?->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kategori</label>
            <select name="expense_category_id" class="form-select">
                <option value="">—</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('expense_category_id', $e?->expense_category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Metode</label>
            <select name="payment_method" class="form-select">
                @foreach(\App\Models\Payment::METHODS as $k => $v)
                    <option value="{{ $k }}" {{ old('payment_method', $e?->payment_method ?? 'cash') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
            <input type="text" name="description" value="{{ old('description', $e?->description) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
            <input type="number" name="amount" value="{{ old('amount', $e?->amount) }}" class="form-control" min="1" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Referensi</label>
            <input type="text" name="reference" value="{{ old('reference', $e?->reference) }}" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $e?->notes) }}</textarea>
        </div>
    </div>
</div></div>