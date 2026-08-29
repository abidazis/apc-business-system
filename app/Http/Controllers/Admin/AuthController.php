<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'is_active' => true], true)) {
            return back()->withErrors(['email' => 'Email atau password salah, atau akun nonaktif.'])->withInput();
        }

        $request->session()->regenerate();

        if (! $request->user()->isAdmin()) {
            Auth::logout();

            return back()->withErrors(['email' => 'Anda tidak memiliki akses ke area admin.'])->withInput();
        }

        Activity::record('auth.login', $request->user());

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($user) {
            Activity::record('auth.logout', null, ['user_id' => $user->id]);
        }

        return redirect()->route('admin.login');
    }
}
