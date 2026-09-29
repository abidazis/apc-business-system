@extends('layouts.auth')
@section('title', 'Login Admin')
@push('styles')
<style>
/* ================================================================
   APC AUTH — PROFESSIONAL LOGIN PAGE
   Split-screen: Dark brand panel (left) + Clean form (right)
   ================================================================ */

.apc-auth-wrapper {
    display: flex;
    min-height: 100vh;
    background: var(--apc-gray-50);
}

/* ── LEFT PANEL (Brand) ── */
.apc-auth-brand {
    display: none;
    width: 45%;
    background: var(--apc-black);
    color: var(--apc-white);
    position: relative;
    overflow: hidden;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 48px;
    @media (min-width: 1024px) { display: flex; }
}

.apc-auth-brand::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(600px 400px at 20% 30%, rgba(255,198,0,.18), transparent 60%),
        radial-gradient(400px 300px at 80% 70%, rgba(255,198,0,.08), transparent 60%);
    pointer-events: none;
}

.apc-auth-brand::after {
    content: "";
    position: absolute;
    top: -120px;
    right: -120px;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: var(--apc-yellow);
    opacity: .06;
    pointer-events: none;
}

.apc-auth-brand-content {
    position: relative;
    z-index: 1;
    max-width: 400px;
    text-align: center;
}

.apc-auth-brand-mark {
    width: 80px;
    height: 80px;
    background: var(--apc-yellow);
    color: var(--apc-black);
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 28px;
    letter-spacing: 0;
    margin-bottom: 32px;
    box-shadow: 0 20px 60px rgba(255,198,0,.35);
    animation: apc-brand-float 6s ease-in-out infinite;
}

@keyframes apc-brand-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.apc-auth-brand h1 {
    color: var(--apc-white);
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin: 0 0 16px;
}

.apc-auth-brand h1 span {
    color: var(--apc-yellow);
}

.apc-auth-brand p {
    color: rgba(255,255,255,.7);
    font-size: 16px;
    line-height: 1.7;
    margin: 0 0 40px;
}

.apc-auth-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 40px;
}

.apc-auth-stat {
    text-align: center;
    padding: 16px 12px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px;
}

.apc-auth-stat-num {
    display: block;
    font-size: 28px;
    font-weight: 800;
    color: var(--apc-yellow);
    letter-spacing: -0.03em;
    line-height: 1;
    margin-bottom: 6px;
}

.apc-auth-stat-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255,255,255,.55);
}

/* Floating decorative elements */
.apc-auth-deco {
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 24px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.06);
}

.apc-auth-deco-1 { top: 15%; left: 10%; transform: rotate(12deg); }
.apc-auth-deco-2 { bottom: 20%; right: 8%; transform: rotate(-8deg); width: 80px; height: 80px; border-radius: 20px; }
.apc-auth-deco-3 { top: 60%; left: 5%; width: 60px; height: 60px; border-radius: 16px; transform: rotate(25deg); }

/* ── RIGHT PANEL (Form) ── */
.apc-auth-form-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 32px 24px;
    @media (min-width: 1024px) { padding: 48px; }
}

.apc-auth-form-wrap {
    width: 100%;
    max-width: 420px;
}

/* Logo / Back to site */
.apc-auth-back {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 500;
    color: var(--apc-text-muted);
    text-decoration: none;
    margin-bottom: 40px;
    transition: color .15s;
}
.apc-auth-back:hover { color: var(--apc-ink); text-decoration: none; }
.apc-auth-back i { font-size: 18px; }

/* Card */
.apc-auth-card {
    background: var(--apc-white);
    border: 1px solid var(--apc-border);
    border-radius: 24px;
    padding: 36px 32px;
    box-shadow: var(--apc-shadow-md);
    @media (min-width: 640px) { padding: 44px 40px; }
}

.apc-auth-card-header {
    text-align: center;
    margin-bottom: 32px;
}

.apc-auth-card-header .icon {
    width: 52px;
    height: 52px;
    background: var(--apc-gray-50);
    border: 1.5px solid var(--apc-border);
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.apc-auth-card-header .icon i { font-size: 24px; color: var(--apc-ink); }

.apc-auth-card-header h2 {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin: 0 0 6px;
    color: var(--apc-ink);
}

.apc-auth-card-header p {
    font-size: 14px;
    color: var(--apc-text-muted);
    margin: 0;
}

/* Form fields */
.apc-auth-field {
    margin-bottom: 20px;
}

.apc-auth-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--apc-ink);
    margin-bottom: 8px;
}
.apc-auth-field label i {
    font-size: 16px;
    color: var(--apc-text-muted);
}

.apc-auth-input-wrap {
    position: relative;
}

.apc-auth-input-wrap .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--apc-text-subtle);
    font-size: 18px;
    pointer-events: none;
    transition: color .15s;
}

.apc-auth-input {
    width: 100%;
    padding: 13px 14px 13px 46px;
    border: 1.5px solid var(--apc-border);
    border-radius: 12px;
    background: var(--apc-white);
    font-size: 15px;
    color: var(--apc-text);
    transition: border-color .15s, box-shadow .15s;
}
.apc-auth-input:focus {
    outline: none;
    border-color: var(--apc-ink);
    box-shadow: 0 0 0 4px rgba(255,198,0,.2);
}
.apc-auth-input:focus ~ .input-icon,
.apc-auth-input-wrap:focus-within .input-icon {
    color: var(--apc-ink);
}
.apc-auth-input::placeholder { color: var(--apc-text-subtle); }
.apc-auth-input.is-invalid { border-color: var(--apc-danger); }

/* Password toggle */
.apc-auth-pw-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--apc-text-subtle);
    cursor: pointer;
    padding: 4px;
    font-size: 18px;
    transition: color .15s;
}
.apc-auth-pw-toggle:hover { color: var(--apc-ink); }

/* Error alert */
.apc-auth-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    background: rgba(220,38,38,.08);
    border: 1px solid rgba(220,38,38,.2);
    border-radius: 12px;
    margin-bottom: 20px;
}
.apc-auth-alert i { font-size: 20px; color: var(--apc-danger); flex-shrink: 0; }
.apc-auth-alert span { font-size: 14px; color: var(--apc-danger); font-weight: 500; }

/* Options row */
.apc-auth-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}

.apc-auth-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}
.apc-auth-remember input { display: none; }
.apc-auth-remember .checkbox {
    width: 20px;
    height: 20px;
    border: 1.5px solid var(--apc-border-strong);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s, border-color .15s;
    flex-shrink: 0;
}
.apc-auth-remember input:checked + .checkbox {
    background: var(--apc-ink);
    border-color: var(--apc-ink);
}
.apc-auth-remember .checkbox i { font-size: 12px; color: var(--apc-white); opacity: 0; }
.apc-auth-remember input:checked + .checkbox i { opacity: 1; }
.apc-auth-remember span { font-size: 14px; color: var(--apc-text-muted); }

/* Submit button */
.apc-auth-submit {
    width: 100%;
    padding: 15px 24px;
    background: var(--apc-ink);
    color: var(--apc-white);
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background .15s, transform .15s, box-shadow .15s;
    box-shadow: 0 4px 14px rgba(11,11,11,.2);
}
.apc-auth-submit:hover {
    background: var(--apc-ink-2);
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(11,11,11,.25);
}
.apc-auth-submit:active { transform: translateY(0); }
.apc-auth-submit i { font-size: 18px; }
.apc-auth-submit.is-loading { pointer-events: none; opacity: .8; }
.apc-auth-submit.is-loading .btn-text { display: none; }
.apc-auth-submit .spinner { display: none; }
.apc-auth-submit.is-loading .spinner { display: flex; align-items: center; gap: 8px; }
.apc-auth-submit .spinner::before {
    content: "";
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: var(--apc-white);
    border-radius: 50%;
    animation: apc-spin .7s linear infinite;
}
@keyframes apc-spin { to { transform: rotate(360deg); } }

/* Footer link */
.apc-auth-footer {
    text-align: center;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--apc-border);
}
.apc-auth-footer a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
    color: var(--apc-text-muted);
    text-decoration: none;
    transition: color .15s;
}
.apc-auth-footer a:hover { color: var(--apc-ink); text-decoration: none; }
.apc-auth-footer a i { font-size: 18px; }

/* Business name badge */
.apc-auth-business {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: var(--apc-gray-50);
    border: 1px solid var(--apc-border);
    border-radius: 100px;
    margin-top: 20px;
}
.apc-auth-business-dot {
    width: 8px;
    height: 8px;
    background: var(--apc-success);
    border-radius: 50%;
    animation: apc-pulse-dot 2s ease-in-out infinite;
}
@keyframes apc-pulse-dot {
    0%, 100% { opacity: 1; }
    50% { opacity: .5; }
}
.apc-auth-business span {
    font-size: 13px;
    font-weight: 600;
    color: var(--apc-text-muted);
}
</style>
@endpush

@section('content')
<div class="apc-auth-wrapper">

    {{-- LEFT: Brand Panel --}}
    <div class="apc-auth-brand">
        <div class="apc-auth-deco apc-auth-deco-1"></div>
        <div class="apc-auth-deco apc-auth-deco-2"></div>
        <div class="apc-auth-deco apc-auth-deco-3"></div>

        <div class="apc-auth-brand-content">
            <div class="apc-auth-brand-mark">APC</div>
            <h1>Dashboard <span>Admin</span></h1>
            <p>Kelola semua aspek bisnis Anda dengan mudah dan efisien dalam satu platform terpusat.</p>

            <div class="apc-auth-stats">
                <div class="apc-auth-stat">
                    <span class="apc-auth-stat-num">24/7</span>
                    <span class="apc-auth-stat-label">Monitoring</span>
                </div>
                <div class="apc-auth-stat">
                    <span class="apc-auth-stat-num">100%</span>
                    <span class="apc-auth-stat-label">Secure</span>
                </div>
                <div class="apc-auth-stat">
                    <span class="apc-auth-stat-num">Real</span>
                    <span class="apc-auth-stat-label">Time</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: Form Panel --}}
    <div class="apc-auth-form-panel">
        <div class="apc-auth-form-wrap">

            {{-- Back to site --}}
            <a href="{{ url('/') }}" class="apc-auth-back">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Website</span>
            </a>

            {{-- Card --}}
            <div class="apc-auth-card">

                <div class="apc-auth-card-header">
                    <div class="icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h2>Masuk Admin</h2>
                    <p>Silakan masukkan kredensial Anda untuk melanjutkan</p>
                </div>

                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="apc-auth-alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" id="loginForm">
                    @csrf

                    {{-- Email --}}
                    <div class="apc-auth-field">
                        <label>
                            <i class="bi bi-envelope"></i>
                            Alamat Email
                        </label>
                        <div class="apc-auth-input-wrap">
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="apc-auth-input"
                                placeholder="admin@email.com"
                                required
                                autofocus
                            >
                            <i class="bi bi-at input-icon"></i>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="apc-auth-field">
                        <label>
                            <i class="bi bi-lock"></i>
                            Password
                        </label>
                        <div class="apc-auth-input-wrap">
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                class="apc-auth-input"
                                placeholder="Masukkan password"
                                required
                                style="padding-right: 46px;"
                            >
                            <i class="bi bi-key input-icon"></i>
                            <button type="button" class="apc-auth-pw-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="pwIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Options --}}
                    <div class="apc-auth-options">
                        <label class="apc-auth-remember">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkbox"><i class="bi bi-check"></i></span>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="apc-auth-submit" id="submitBtn">
                        <span class="btn-text">
                            Masuk
                            <i class="bi bi-arrow-right"></i>
                        </span>
                        <span class="spinner">Memproses...</span>
                    </button>
                </form>

                <div class="apc-auth-footer">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-house"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- Business Name --}}
            <div class="text-center" style="margin-top: 24px;">
                <div class="apc-auth-business">
                    <div class="apc-auth-business-dot"></div>
                    <span>{{ \App\Support\Settings::get('business_name') }}</span>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('pwIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

// Loading state on submit
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.classList.add('is-loading');
    btn.disabled = true;
});
</script>
@endsection
