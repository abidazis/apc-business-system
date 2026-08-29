@php
    $label = $label ?? 'Chat WhatsApp';
    $msg = $msg ?? \App\Support\WhatsApp::messageGeneral();
@endphp
<a href="{{ \App\Support\WhatsApp::url($msg) }}" target="_blank" rel="noopener" class="apc-fab" aria-label="{{ $label }}">
    <span class="apc-fab-pulse"></span>
    <i class="bi bi-whatsapp"></i>
    <span class="d-none d-md-inline">{{ $label }}</span>
</a>