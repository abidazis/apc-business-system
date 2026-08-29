<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->isActive()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Sesi tidak valid atau akun tidak aktif.']);
        }

        // For users that are authenticated but lack role authorization, let the
        // Gate authorization (controller-level) produce a 403 response.
        return $next($request);
    }
}
