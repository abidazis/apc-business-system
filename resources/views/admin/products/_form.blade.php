@php $p = $product ?? null; @endphp
<div class="apc-card mb-3">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="apc-field">
                    <label class="apc-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $p?->name) }}" class="apc-input" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="apc-field">
                    <label class="apc-label">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $p?->sku) }}" class="apc-input">
                </div>
            </div>
            <div class="col-md-6">
                <div class="apc-field">
                    <label class="apc-label">Kategori</label>
                    <select name="category_id" class="apc-select">
                        <option value="">— Pilih —</option>
                        @foreach($categories ?? [] as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $p?->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="apc-field">
                    <label class="apc-label">Slug <span class="apc-help">(otomatis jika kosong)</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $p?->slug) }}" class="apc-input">
                </div>
            </div>
            <div class="col-12">
                <div class="apc-field">
                    <label class="apc-label">Deskripsi Singkat</label>
                    <textarea name="short_description" rows="2" maxlength="500" class="apc-textarea">{{ old('short_description', $p?->short_description) }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="apc-field">
                    <label class="apc-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="apc-textarea">{{ old('description', $p?->description) }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="apc-field">
                    <label class="apc-label">Spesifikasi</label>
                    <textarea name="specifications" rows="3" class="apc-textarea">{{ old('specifications', $p?->specifications) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="apc-card mb-3">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="apc-field">
                    <label class="apc-label">Tipe Harga</label>
                    <select name="price_type" class="apc-select">
                        <option value="contact" {{ old('price_type', $p?->price_type ?? 'contact') === 'contact' ? 'selected' : '' }}>Hubungi Kami</option>
                        <option value="starting_from" {{ old('price_type', $p?->price_type) === 'starting_from' ? 'selected' : '' }}>Mulai Dari</option>
                        <option value="fixed" {{ old('price_type', $p?->price_type) === 'fixed' ? 'selected' : '' }}>Harga Pasti</option>
                    </select>
                </div>
            </div>
            <div class="col-md-8">
                <div class="apc-field">
                    <label class="apc-label">Harga <span class="apc-help">(opsional)</span></label>
                    <input type="number" name="price" value="{{ old('price', $p?->price) }}" class="apc-input" step="1" min="0">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="apc-card mb-3">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="apc-field">
                    <label class="apc-label">Gambar</label>
                    @if($p?->image)
                        <div class="mb-2"><img src="{{ $p->image_url }}" alt="" width="120" style="border-radius: var(--apc-radius-sm);"></div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="apc-input">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $p?->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pub">Published</label>
                </div>
                <div class="form-check form-switch">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="feat" {{ old('is_featured', $p?->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="feat">Tampilkan di Homepage</label>
                </div>
            </div>
        </div>
    </div>
</div>