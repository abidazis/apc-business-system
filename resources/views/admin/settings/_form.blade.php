@php $v = $values ?? []; @endphp
<div class="card mb-3">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Identitas Bisnis</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Bisnis <span class="text-danger">*</span></label>
                <input type="text" name="business_name" value="{{ old('business_name', $v['business_name'] ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Pendek</label>
                <input type="text" name="business_short" value="{{ old('business_short', $v['business_short'] ?? 'APC') }}" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $v['tagline'] ?? '') }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Tentang Singkat</label>
                <textarea name="about_short" rows="2" class="form-control">{{ old('about_short', $v['about_short'] ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo</label>
                @if(!empty($v['logo']))
                    <div class="mb-2"><img src="{{ asset('storage/' . $v['logo']) }}" alt="" width="120" class="rounded border"></div>
                @endif
                <input type="file" name="logo" accept="image/*" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Hero Image (Homepage)</label>
                @if(!empty($v['hero_image']))
                    <div class="mb-2"><img src="{{ asset('storage/' . $v['hero_image']) }}" alt="" width="180" class="rounded border"></div>
                @endif
                <input type="file" name="hero_image" accept="image/*" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Kontak</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Alamat</label>
                <textarea name="address" rows="2" class="form-control">{{ old('address', $v['address'] ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $v['phone'] ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $v['email'] ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">WhatsApp <span class="text-danger">*</span> <small class="text-muted">(format: 62812xxx)</small></label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $v['whatsapp'] ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $v['instagram'] ?? '') }}" class="form-control" placeholder="@username">
            </div>
            <div class="col-md-3">
                <label class="form-label">TikTok</label>
                <input type="text" name="tiktok" value="{{ old('tiktok', $v['tiktok'] ?? '') }}" class="form-control" placeholder="@username">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-white"><h6 class="fw-bold mb-0">Invoice & Currency</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Currency Code</label>
                <input type="text" name="currency" value="{{ old('currency', $v['currency'] ?? 'IDR') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Currency Symbol</label>
                <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $v['currency_symbol'] ?? 'Rp') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Invoice Prefix</label>
                <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $v['invoice_prefix'] ?? 'INV') }}" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Order Prefix</label>
                <input type="text" name="order_prefix" value="{{ old('order_prefix', $v['order_prefix'] ?? 'ORD') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Bank</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $v['bank_name'] ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Atas Nama</label>
                <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $v['bank_account_name'] ?? '') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">No. Rekening</label>
                <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $v['bank_account_number'] ?? '') }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Footer Note (Invoice)</label>
                <textarea name="footer_note" rows="2" class="form-control">{{ old('footer_note', $v['footer_note'] ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>