<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $values = Settings::all();
        return view('admin.settings.index', compact('values'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:160'],
            'business_short' => ['required', 'string', 'max:30'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'about_short' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:160'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'instagram' => ['nullable', 'string', 'max:60'],
            'tiktok' => ['nullable', 'string', 'max:60'],
            'invoice_prefix' => ['required', 'string', 'max:10'],
            'order_prefix' => ['required', 'string', 'max:10'],
            'currency' => ['required', 'string', 'max:10'],
            'currency_symbol' => ['required', 'string', 'max:5'],
            'bank_name' => ['nullable', 'string', 'max:80'],
            'bank_account_name' => ['nullable', 'string', 'max:120'],
            'bank_account_number' => ['nullable', 'string', 'max:60'],
            'footer_note' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('settings', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        foreach ($data as $key => $value) {
            Settings::set($key, $value, $key === 'invoice_prefix' || $key === 'order_prefix' || $key === 'currency' ? 'invoice' : 'general');
        }

        return back()->with('success', 'Settings disimpan.');
    }
}