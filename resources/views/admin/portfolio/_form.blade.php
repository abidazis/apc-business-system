@php $p = $project ?? null; $attached = $attached ?? []; @endphp
<div class="apc-card mb-3">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-md-8 apc-field"><label class="apc-label">Judul <span class="text-danger">*</span></label><input type="text" name="title" value="{{ old('title', $p?->title) }}" class="apc-input" required></div>
            <div class="col-md-4 apc-field"><label class="apc-label">Slug</label><input type="text" name="slug" value="{{ old('slug', $p?->slug) }}" class="apc-input"></div>
            <div class="col-md-6 apc-field"><label class="apc-label">Nama Customer</label><input type="text" name="customer_name" value="{{ old('customer_name', $p?->customer_name) }}" class="apc-input"></div>
            <div class="col-md-3 apc-field"><label class="apc-label">Tanggal Proyek</label><input type="date" name="project_date" value="{{ old('project_date', $p?->project_date?->format('Y-m-d')) }}" class="apc-input"></div>
            <div class="col-md-3 apc-field"><label class="apc-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $p?->sort_order ?? 0) }}" class="apc-input"></div>
            <div class="col-12 apc-field"><label class="apc-label">Deskripsi</label><textarea name="description" rows="4" class="apc-textarea">{{ old('description', $p?->description) }}</textarea></div>
            <div class="col-md-6 apc-field">
                <label class="apc-label">Cover Image</label>
                @if($p?->cover_image)<div class="mb-2"><img src="{{ $p->cover_image_url }}" alt="" width="180" style="border-radius: var(--apc-radius);"></div>@endif
                <input type="file" name="cover_image" accept="image/*" class="apc-input">
            </div>
            <div class="col-md-6 apc-field d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $p?->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pub">Published</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="apc-card">
    <div class="card-body p-3 p-md-4">
        <h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Produk yang Digunakan</h6>
        <div class="apc-table-wrap">
            <table class="apc-table">
                <thead><tr><th style="width:60px;"></th><th>Produk</th><th style="width:120px;">Qty</th></tr></thead>
                <tbody>
                    @foreach($products as $prod)
                        <tr>
                            <td><input type="checkbox" name="products[]" value="{{ $prod->id }}" {{ in_array($prod->id, array_keys($attached)) ? 'checked' : '' }}></td>
                            <td>{{ $prod->name }}</td>
                            <td><input type="number" name="product_quantities[{{ $prod->id }}]" value="{{ old('product_quantities.' . $prod->id, $attached[$prod->id] ?? 1) }}" class="apc-input" min="1"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>