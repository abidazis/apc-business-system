@php $v = $values ?? []; @endphp
<h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Kontak</h6>
<div class="row g-3 mb-4">
    <div class="col-md-12 apc-field"><label class="apc-label">Alamat</label><textarea name="address" rows="2" class="apc-textarea">{{ old('address', $v['address'] ?? '') }}</textarea></div>
    <div class="col-md-6 apc-field"><label class="apc-label">Telepon</label><input type="text" name="phone" value="{{ old('phone', $v['phone'] ?? '') }}" class="apc-input"></div>
    <div class="col-md-6 apc-field"><label class="apc-label">Email</label><input type="email" name="email" value="{{ old('email', $v['email'] ?? '') }}" class="apc-input"></div>
    <div class="col-md-6 apc-field"><label class="apc-label">WhatsApp <span class="text-danger">*</span> <span class="apc-help">(format: 62812xxx)</span></label><input type="text" name="whatsapp" value="{{ old('whatsapp', $v['whatsapp'] ?? '') }}" class="apc-input" required></div>
    <div class="col-md-3 apc-field"><label class="apc-label">Instagram</label><input type="text" name="instagram" value="{{ old('instagram', $v['instagram'] ?? '') }}" class="apc-input" placeholder="@username"></div>
    <div class="col-md-3 apc-field"><label class="apc-label">TikTok</label><input type="text" name="tiktok" value="{{ old('tiktok', $v['tiktok'] ?? '') }}" class="apc-input" placeholder="@username"></div>
</div>

<h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Invoice & Currency</h6>
<div class="row g-3 mb-4">
    <div class="col-md-3 apc-field"><label class="apc-label">Currency Code</label><input type="text" name="currency" value="{{ old('currency', $v['currency'] ?? 'IDR') }}" class="apc-input" required></div>
    <div class="col-md-3 apc-field"><label class="apc-label">Currency Symbol</label><input type="text" name="currency_symbol" value="{{ old('currency_symbol', $v['currency_symbol'] ?? 'Rp') }}" class="apc-input" required></div>
    <div class="col-md-3 apc-field"><label class="apc-label">Invoice Prefix</label><input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $v['invoice_prefix'] ?? 'INV') }}" class="apc-input" required></div>
    <div class="col-md-3 apc-field"><label class="apc-label">Order Prefix</label><input type="text" name="order_prefix" value="{{ old('order_prefix', $v['order_prefix'] ?? 'ORD') }}" class="apc-input" required></div>
    <div class="col-md-4 apc-field"><label class="apc-label">Bank</label><input type="text" name="bank_name" value="{{ old('bank_name', $v['bank_name'] ?? '') }}" class="apc-input"></div>
    <div class="col-md-4 apc-field"><label class="apc-label">Atas Nama</label><input type="text" name="bank_account_name" value="{{ old('bank_account_name', $v['bank_account_name'] ?? '') }}" class="apc-input"></div>
    <div class="col-md-4 apc-field"><label class="apc-label">No. Rekening</label><input type="text" name="bank_account_number" value="{{ old('bank_account_number', $v['bank_account_number'] ?? '') }}" class="apc-input"></div>
    <div class="col-12 apc-field"><label class="apc-label">Footer Note (Invoice)</label><textarea name="footer_note" rows="2" class="apc-textarea">{{ old('footer_note', $v['footer_note'] ?? '') }}</textarea></div>
</div>

<h6 class="fw-bold mb-3" style="font-size: 13px; letter-spacing: 0.06em; text-transform: uppercase; color: var(--apc-text-muted);">Identitas & Visual</h6>
<div class="row g-3">
    <div class="col-md-8 apc-field"><label class="apc-label">Nama Bisnis <span class="text-danger">*</span></label><input type="text" name="business_name" value="{{ old('business_name', $v['business_name'] ?? '') }}" class="apc-input" required></div>
    <div class="col-md-4 apc-field"><label class="apc-label">Nama Pendek</label><input type="text" name="business_short" value="{{ old('business_short', $v['business_short'] ?? 'APC') }}" class="apc-input" required></div>
    <div class="col-12 apc-field"><label class="apc-label">Tagline</label><input type="text" name="tagline" value="{{ old('tagline', $v['tagline'] ?? '') }}" class="apc-input"></div>
    <div class="col-12 apc-field"><label class="apc-label">Tentang Singkat</label><textarea name="about_short" rows="2" class="apc-textarea">{{ old('about_short', $v['about_short'] ?? '') }}</textarea></div>
    <div class="col-md-6 apc-field">
        <label class="apc-label">Logo</label>
        @if(!empty($v['logo']))<div class="mb-2"><img src="{{ asset('storage/' . $v['logo']) }}" alt="" width="120" style="border-radius: var(--apc-radius-sm);"></div>@endif
        <input type="file" name="logo" accept="image/*" class="apc-input">
    </div>
    <div class="col-md-6 apc-field">
        <label class="apc-label">Hero Image (Homepage)</label>
        @if(!empty($v['hero_image']))<div class="mb-2"><img src="{{ asset('storage/' . $v['hero_image']) }}" alt="" width="180" style="border-radius: var(--apc-radius-sm);"></div>@endif
        <input type="file" name="hero_image" accept="image/*" class="apc-input">
    </div>
</div>