<div class="row g-3">
    <div class="col-md-6 apc-field">
        <label class="apc-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $customer?->name ?? null) }}" class="apc-input" required>
    </div>
    <div class="col-md-6 apc-field">
        <label class="apc-label">Organisasi / Sekolah</label>
        <input type="text" name="organization" value="{{ old('organization', $customer?->organization ?? null) }}" class="apc-input">
    </div>
    <div class="col-md-6 apc-field">
        <label class="apc-label">Telepon / WhatsApp</label>
        <input type="text" name="phone" value="{{ old('phone', $customer?->phone ?? null) }}" class="apc-input">
    </div>
    <div class="col-md-6 apc-field">
        <label class="apc-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $customer?->email ?? null) }}" class="apc-input">
    </div>
    <div class="col-12 apc-field">
        <label class="apc-label">Alamat</label>
        <textarea name="address" rows="2" class="apc-textarea">{{ old('address', $customer?->address ?? null) }}</textarea>
    </div>
    <div class="col-12 apc-field">
        <label class="apc-label">Catatan</label>
        <textarea name="notes" rows="3" class="apc-textarea">{{ old('notes', $customer?->notes ?? null) }}</textarea>
    </div>
</div>
