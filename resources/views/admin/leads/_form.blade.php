@php $l = $lead ?? null; @endphp
<div class="card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama Kontak <span class="text-danger">*</span></label>
            <input type="text" name="contact_name" value="{{ old('contact_name', $l?->contact_name) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Organisasi</label>
            <input type="text" name="organization" value="{{ old('organization', $l?->organization) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Telepon / WhatsApp</label>
            <input type="text" name="phone" value="{{ old('phone', $l?->phone) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $l?->email) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sumber</label>
            <input type="text" name="source" value="{{ old('source', $l?->source) }}" class="form-control" placeholder="Website / IG / WA / Referral">
        </div>
        <div class="col-md-4">
            <label class="form-label">Estimasi Nilai</label>
            <input type="number" name="estimated_value" value="{{ old('estimated_value', $l?->estimated_value) }}" class="form-control" min="0">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select">
                @foreach(\App\Models\Lead::STATUSES as $s)
                    <option value="{{ $s }}" {{ old('status', $l?->status ?? 'new') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Follow Up</label>
            <input type="date" name="follow_up_date" value="{{ old('follow_up_date', $l?->follow_up_date?->format('Y-m-d')) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ditugaskan ke</label>
            <select name="assigned_to" class="form-select">
                <option value="">—</option>
                @foreach($users ?? [] as $u)
                    <option value="{{ $u->id }}" {{ old('assigned_to', $l?->assigned_to) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Customer (jika sudah ada)</label>
            <select name="customer_id" class="form-select">
                <option value="">—</option>
                @foreach($customers ?? [] as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id', $l?->customer_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="3" class="form-control">{{ old('notes', $l?->notes) }}</textarea>
        </div>
    </div>
</div></div>