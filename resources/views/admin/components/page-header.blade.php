<div class="apc-page-header">
    <div class="d-flex justify-content-between align-items-start w-100">
        <div>
            <h1>{{ $title }}</h1>
            @if($subtitle ?? null)
                <p class="apc-muted mb-0" style="font-size: 14px;">{{ $subtitle }}</p>
            @endif
        </div>
        @if(isset($slot) && trim($slot))
            <div class="d-flex gap-2 flex-wrap">
                {!! $slot !!}
            </div>
        @endif
    </div>
</div>
