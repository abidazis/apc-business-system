@php
    $p = $product ?? null;
@endphp
<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $p?->name) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $p?->sku) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">— Pilih —</option>
                    @foreach($categories ?? [] as $c)
                        <option value="{{ $c->id }}" {{ old('category_id', $p?->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug <small class="text-muted">(auto jika kosong)</small></label>
                <input type="text" name="slug" value="{{ old('slug', $p?->slug) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="short_description" rows="2" maxlength="500" class="form-control">{{ old('short_description', $p?->short_description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $p?->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Spesifikasi</label>
                <textarea name="specifications" rows="3" class="form-control">{{ old('specifications', $p?->specifications) }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tipe Harga</label>
                <select name="price_type" class="form-select">
                    <option value="contact" {{ old('price_type', $p?->price_type ?? 'contact') === 'contact' ? 'selected' : '' }}>Hubungi Kami</option>
                    <option value="starting_from" {{ old('price_type', $p?->price_type) === 'starting_from' ? 'selected' : '' }}>Mulai Dari</option>
                    <option value="fixed" {{ old('price_type', $p?->price_type) === 'fixed' ? 'selected' : '' }}>Harga Pasti</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Harga <small class="text-muted">(opsional)</small></label>
                <input type="number" name="price" value="{{ old('price', $p?->price) }}" class="form-control" step="1" min="0">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Gambar</label>
                @if($p?->image)
                    <div class="mb-2"><img src="{{ $p->image_url }}" alt="" width="120" class="rounded border"></div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-control">
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
                    <label class="form-check-label" for="feat">Tampilkan di Beranda</label>
                </div>
            </div>
        </div>
    </div>
</div>