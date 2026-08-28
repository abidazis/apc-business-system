@php
    $o = $order ?? null;
    $isEdit = (bool) $o;
    $items = old('items', $o ? $o->items->map(fn ($i) => [
        'product_id' => $i->product_id,
        'description' => $i->description,
        'quantity' => $i->quantity,
        'unit_price' => (float) $i->unit_price,
        'hpp' => (float) $i->hpp,
    ])->toArray() : [['description' => '', 'quantity' => 1, 'unit_price' => 0, 'hpp' => 0]]);
    $customers = $customers ?? collect();
    $leads = $leads ?? collect();
    $lead = $lead ?? null;
@endphp
<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Customer <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-select" required>
                    <option value="">— Pilih Customer —</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id', $o?->customer_id ?? $lead?->customer_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.customers.create') }}" target="_blank" class="small">+ Customer Baru</a>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Order</label>
                <input type="date" name="order_date" value="{{ old('order_date', $o?->order_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline', $o?->deadline?->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(\App\Models\Order::STATUSES as $k => $v)
                        <option value="{{ $k }}" {{ old('status', $o?->status ?? 'lead') === $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Lead (opsional)</label>
                <select name="lead_id" class="form-select">
                    <option value="">—</option>
                    @foreach($leads as $l)
                        <option value="{{ $l->id }}" {{ old('lead_id', $o?->lead_id ?? $lead?->id) == $l->id ? 'selected' : '' }}>{{ $l->contact_name }} {{ $l->organization ? '(' . $l->organization . ')' : '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Item Order</h6>
        <button type="button" id="addItem" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i> Tambah Item</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" id="itemsTable">
                <thead class="table-light">
                    <tr>
                        <th>Deskripsi</th>
                        <th width="90">Qty</th>
                        <th width="140">Harga</th>
                        <th width="140">HPP</th>
                        <th width="140">Subtotal</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                @foreach($items as $idx => $it)
                    <tr>
                        <td>
                            <input type="text" name="items[{{ $idx }}][description]" value="{{ $it['description'] ?? '' }}" class="form-control" required>
                            <input type="hidden" name="items[{{ $idx }}][product_id]" value="{{ $it['product_id'] ?? '' }}">
                        </td>
                        <td><input type="number" name="items[{{ $idx }}][quantity]" value="{{ $it['quantity'] ?? 1 }}" class="form-control item-qty" min="1" required></td>
                        <td><input type="number" name="items[{{ $idx }}][unit_price]" value="{{ $it['unit_price'] ?? 0 }}" class="form-control item-price" min="0" step="1" required></td>
                        <td><input type="number" name="items[{{ $idx }}][hpp]" value="{{ $it['hpp'] ?? 0 }}" class="form-control item-hpp" min="0" step="1" required></td>
                        <td class="item-subtotal fw-semibold">{{ \App\Services\Formatter::money(($it['quantity'] ?? 1) * ($it['unit_price'] ?? 0)) }}</td>
                        <td><button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="bi bi-x"></i></button></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Subtotal</th>
                        <th id="subtotalDisplay" class="fw-bold">Rp 0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Discount</label>
                <input type="number" name="discount" value="{{ old('discount', $o?->discount ?? 0) }}" class="form-control" min="0" step="1" id="discount">
            </div>
            <div class="col-md-4">
                <label class="form-label">Shipping</label>
                <input type="number" name="shipping_cost" value="{{ old('shipping_cost', $o?->shipping_cost ?? 0) }}" class="form-control" min="0" step="1" id="shipping">
            </div>
            <div class="col-md-4">
                <label class="form-label">TOTAL</label>
                <div class="h4 fw-bold apc-brand-color" id="totalDisplay">Rp 0</div>
            </div>
            <div class="col-12">
                <label class="form-label">Catatan</label>
                <textarea name="notes" rows="2" class="form-control">{{ old('notes', $o?->notes) }}</textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.getElementById('itemsBody');
    const fmt = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));
    let idx = body.querySelectorAll('tr').length;

    function recalc() {
        let sub = 0;
        body.querySelectorAll('tr').forEach((tr) => {
            const q = parseFloat(tr.querySelector('.item-qty').value) || 0;
            const p = parseFloat(tr.querySelector('.item-price').value) || 0;
            const st = q * p;
            tr.querySelector('.item-subtotal').textContent = fmt(st);
            sub += st;
        });
        const disc = parseFloat(document.getElementById('discount').value) || 0;
        const ship = parseFloat(document.getElementById('shipping').value) || 0;
        document.getElementById('subtotalDisplay').textContent = fmt(sub);
        document.getElementById('totalDisplay').textContent = fmt(sub - disc + ship);
    }

    body.addEventListener('input', recalc);
    document.getElementById('discount').addEventListener('input', recalc);
    document.getElementById('shipping').addEventListener('input', recalc);

    document.getElementById('addItem').addEventListener('click', function () {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="items[${idx}][description]" class="form-control" required><input type="hidden" name="items[${idx}][product_id]" value=""></td>
            <td><input type="number" name="items[${idx}][quantity]" value="1" class="form-control item-qty" min="1" required></td>
            <td><input type="number" name="items[${idx}][unit_price]" value="0" class="form-control item-price" min="0" step="1" required></td>
            <td><input type="number" name="items[${idx}][hpp]" value="0" class="form-control item-hpp" min="0" step="1" required></td>
            <td class="item-subtotal fw-semibold">Rp 0</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="bi bi-x"></i></button></td>
        `;
        body.appendChild(tr);
        idx++;
        recalc();
    });

    body.addEventListener('click', function (e) {
        if (e.target.closest('.remove-item')) {
            if (body.querySelectorAll('tr').length <= 1) {
                alert('Minimal 1 item.');
                return;
            }
            e.target.closest('tr').remove();
            recalc();
        }
    });

    recalc();
});
</script>
@endpush