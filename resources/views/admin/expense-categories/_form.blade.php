@php $c = $category ?? null; @endphp
<div class="apc-field"><label class="apc-label">Nama <span class="text-danger">*</span></label><input type="text" name="name" value="{{ old('name', $c->name ?? '') }}" class="apc-input" required></div>
<div class="apc-field"><label class="apc-label">Slug</label><input type="text" name="slug" value="{{ old('slug', $c->slug ?? '') }}" class="apc-input"></div>