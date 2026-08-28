<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
