@php $c = $category ?? null; @endphp
<div class="apc-field">
    <label class="apc-label">Nama <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $c->name ?? '') }}" class="apc-input" required>
</div>
<div class="apc-field">
    <label class="apc-label">Slug <span class="apc-help">(otomatis jika kosong)</span></label>
    <input type="text" name="slug" value="{{ old('slug', $c->slug ?? '') }}" class="apc-input">
</div>
<div class="apc-field">
    <label class="apc-label">Deskripsi</label>
    <textarea name="description" rows="3" class="apc-textarea">{{ old('description', $c->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 apc-field">
        <label class="apc-label">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $c->sort_order ?? 0) }}" class="apc-input">
    </div>
    <div class="col-md-6 apc-field d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $c->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Aktif</label>
        </div>
    </div>
</div>