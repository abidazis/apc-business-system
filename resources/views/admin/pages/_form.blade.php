@php $p = $page ?? null; @endphp
<form method="POST" action="{{ $p ? route('admin.pages.update', $p) : route('admin.pages.store') }}">
    @csrf @if($p) @method('PUT') @endif
    <div class="card"><div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" value="{{ old('slug', $p?->slug) }}" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" name="title" value="{{ old('title', $p?->title) }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Konten</label>
                <textarea name="content" rows="12" class="form-control">{{ old('content', $p?->content) }}</textarea>
            </div>
            <div class="col-12">
                <input type="hidden" name="is_published" value="0">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $p?->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pub">Published</label>
                </div>
            </div>
        </div>
    </div></div>
    <div class="d-flex gap-2 mt-4">
        <button class="btn apc-brand-bg">Simpan</button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>