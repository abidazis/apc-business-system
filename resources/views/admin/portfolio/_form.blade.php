@php $p = $project ?? null; $attached = $attached ?? []; @endphp
<div class="card mb-3"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{ old('title', $p?->title) }}" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $p?->slug) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Customer</label>
            <input type="text" name="customer_name" value="{{ old('customer_name', $p?->customer_name) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Proyek</label>
            <input type="date" name="project_date" value="{{ old('project_date', $p?->project_date?->format('Y-m-d')) }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $p?->sort_order ?? 0) }}" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $p?->description) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cover Image</label>
            @if($p?->cover_image)
                <div class="mb-2"><img src="{{ $p->cover_image_url }}" alt="" width="180" class="rounded border"></div>
            @endif
            <input type="file" name="cover_image" accept="image/*" class="form-control">
        </div>
        <div class="col-md-6">
            <div class="form-check form-switch mt-4">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $p?->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="pub">Published</label>
            </div>
        </div>
    </div>
</div></div>

<div class="card"><div class="card-body">
    <h6 class="fw-bold mb-3">Produk yang Digunakan</h6>
    <table class="table table-sm">
        <thead><tr><th width="40"></th><th>Produk</th><th width="100">Qty</th></tr></thead>
        <tbody>
            @foreach($products as $prod)
                <tr>
                    <td>
                        <input type="checkbox" name="products[]" value="{{ $prod->id }}" {{ in_array($prod->id, array_keys($attached)) ? 'checked' : '' }}>
                    </td>
                    <td>{{ $prod->name }}</td>
                    <td><input type="number" name="product_quantities[{{ $prod->id }}]" value="{{ old('product_quantities.' . $prod->id, $attached[$prod->id] ?? 1) }}" class="form-control form-control-sm" min="1"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div></div>