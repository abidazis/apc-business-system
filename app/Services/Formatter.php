<?php

namespace App\Services;

use App\Support\Settings;

class Formatter
{
    /**
     * Format an integer amount as Indonesian currency string.
     */
    public static function money(float|int|string|null $amount): string
    {
        $symbol = Settings::currencySymbol();
        $value = (float) ($amount ?? 0);
        return $symbol . ' ' . number_format($value, 0, ',', '.');
    }

    public static function dateId($date): string
    {
        if (! $date) return '-';
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
    }

    public static function dateTimeId($date): string
    {
        if (! $date) return '-';
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i');
    }
}
