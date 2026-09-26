@if(session('success'))
    <div class="apc-flash-inline apc-flash-inline-success" id="flash-success">
        <div class="apc-flash-icon"><i class="bi bi-check-lg"></i></div>
        <p class="apc-flash-text">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="apc-flash-inline apc-flash-inline-error" id="flash-error">
        <div class="apc-flash-icon"><i class="bi bi-x-lg"></i></div>
        <p class="apc-flash-text">{{ session('error') }}</p>
    </div>
@endif
@if($errors->any())
    <div class="apc-flash-inline apc-flash-inline-error" id="flash-errors">
        <div class="apc-flash-icon"><i class="bi bi-exclamation-lg"></i></div>
        <div>
            <p class="apc-flash-text">Ada kesalahan:</p>
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<style>
@keyframes apc-flash-pop {
    0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
    50% { transform: translate(-50%, -50%) scale(1.03); }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
}
@keyframes apc-icon-bounce {
    0% { transform: scale(0); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
@keyframes apc-flash-fade {
    to { transform: translate(-50%, -50%) scale(0.9); opacity: 0; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.querySelector('.apc-flash-inline');
    if (flash) {
        // Animate icon
        const icon = flash.querySelector('.apc-flash-icon');
        if (icon) {
            icon.style.animation = 'apc-icon-bounce 0.5s ease 0.2s both';
        }

        // Auto dismiss
        setTimeout(() => {
            flash.style.animation = 'apc-flash-fade 0.3s ease forwards';
            setTimeout(() => flash.remove(), 300);
        }, 2500);
    }
});
</script>
