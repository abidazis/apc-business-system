<div class="mb-3">
    <label class="form-label">Nama <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label">Slug <small class="text-muted">(kosongkan untuk generate otomatis)</small></label>
    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Aktif</label>
        </div>
    </div>
</div>