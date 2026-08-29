@props(['title', 'subtitle' => null])
<div class="apc-page-header">
    <div>
        <h1>{{ $title }}</h1>
        @if($subtitle)<p class="apc-muted mb-0" style="font-size: 14px;">{{ $subtitle }}</p>@endif
    </div>
    @isset($actions)<div class="d-flex gap-2 flex-wrap">{{ $actions }}</div>@endisset
</div>