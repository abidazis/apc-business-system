@props(['icon' => 'inbox', 'title' => 'Belum ada data', 'message' => null])
<div class="apc-empty">
    <i class="bi bi-{{ $icon }}"></i>
    <h3>{{ $title }}</h3>
    @if($message)<p>{{ $message }}</p>@endif
    {{ $slot }}
</div>