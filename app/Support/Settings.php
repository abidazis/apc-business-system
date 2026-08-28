<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    public const DEFAULTS = [
        'business_name' => 'APC - Atribut Paskibra Cikarang',
        'business_short' => 'APC',
        'tagline' => 'Perlengkapan Paskibra untuk Tim yang Siap Tampil Maksimal.',
        'about_short' => 'APC adalah penyedia atribut dan perlengkapan Paskibra yang melayani kebutuhan individu, sekolah, dan instansi.',
        'address' => 'Cikarang, Kabupaten Bekasi, Jawa Barat',
        'email' => 'admin@apc.example',
        'phone' => '+62 812-0000-0000',
        'whatsapp' => '6281200000000',
        'instagram' => 'apc.paskibra',
        'tiktok' => 'apc.paskibra',
        'logo' => '',
        'invoice_prefix' => 'INV',
        'order_prefix' => 'ORD',
        'currency' => 'IDR',
        'currency_symbol' => 'Rp',
        'bank_name' => '',
        'bank_account_name' => '',
        'bank_account_number' => '',
        'footer_note' => 'Terima kasih telah mempercayakan kebutuhan Paskibra Anda kepada APC.',
        'hero_image' => '',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $cached = Cache::rememberForever('apc.settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
        $value = $cached[$key] ?? null;
        if ($value === null || $value === '') {
            $value = self::DEFAULTS[$key] ?? $default;
        }
        return $value;
    }

    public static function currencySymbol(): string
    {
        return self::get('currency_symbol', 'Rp');
    }

    public static function whatsappNumber(): string
    {
        $number = (string) self::get('whatsapp', '');
        // Normalize: strip non-digits
        $digits = preg_replace('/[^0-9]/', '', $number) ?? '';
        // Indonesian numbers often come as 08xx, convert to 62xxx
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        return $digits;
    }

    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget('apc.settings');
    }

    public static function setMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $k => $v) {
            self::set($k, $v, $group);
        }
    }

    public static function all(): array
    {
        $merged = self::DEFAULTS;
        $stored = Cache::rememberForever('apc.settings', fn () => Setting::pluck('value', 'key')->toArray());
        foreach ($stored as $k => $v) {
            if ($v !== null && $v !== '') {
                $merged[$k] = $v;
            }
        }
        return $merged;
    }
}
