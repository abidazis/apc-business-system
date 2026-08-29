@php $f = $faq ?? null; @endphp
<form method="POST" action="{{ $f ? route('admin.faqs.update', $f) : route('admin.faqs.store') }}">
    @csrf @if($f) @method('PUT') @endif
    <div class="apc-card">
        <div class="card-body p-3 p-md-4">
            <div class="apc-field"><label class="apc-label">Pertanyaan <span class="text-danger">*</span></label><input type="text" name="question" value="{{ old('question', $f?->question) }}" class="apc-input" required></div>
            <div class="apc-field"><label class="apc-label">Jawaban <span class="text-danger">*</span></label><textarea name="answer" rows="4" class="apc-textarea" required>{{ old('answer', $f?->answer) }}</textarea></div>
            <div class="row g-3">
                <div class="col-md-6 apc-field"><label class="apc-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $f?->sort_order ?? 0) }}" class="apc-input"></div>
                <div class="col-md-6 apc-field d-flex align-items-end">
                    <input type="hidden" name="is_published" value="0">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $f?->is_published ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="pub">Published</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button class="apc-btn apc-btn-primary">Simpan</button>
        <a href="{{ route('admin.faqs.index') }}" class="apc-btn apc-btn-ghost">Batal</a>
    </div>
</form>