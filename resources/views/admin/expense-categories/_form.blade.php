<div class="card"><div class="card-body">
    <div class="mb-3">
        <label class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $category?->name) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category?->slug) }}" class="form-control">
    </div>
</div></div>