<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Support\Settings;
use Illuminate\Support\Facades\DB;

class NumberGenerator
{
    /**
     * Generate a unique order number using format ORD-NNNN-MM-YYYY
     * Sequential per month/year.
     */
    public static function orderNumber(): string
    {
        $prefix = Settings::get('order_prefix', 'ORD');
        return self::sequential($prefix, Order::class, 'order_number');
    }

    /**
     * Generate invoice number per user format: INV-NOMOR URUT INVOICE-BULAN-TAHUN
     * e.g. INV-0001-08-2026
     */
    public static function invoiceNumber(): string
    {
        $prefix = Settings::get('invoice_prefix', 'INV');
        $now = now();
        $ym = $now->format('m-Y');
        $month = $now->format('m');
        $year = $now->format('Y');

        // Count invoices created this month for running number
        $count = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $now->month)
            ->withTrashed()
            ->count();

        $seq = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
        $number = "{$prefix}-{$seq}-{$month}-{$year}";

        // Defensive: ensure unique (extremely unlikely collision)
        $attempts = 0;
        while (Invoice::withTrashed()->where('invoice_number', $number)->exists() && $attempts < 50) {
            $seq = str_pad((string) ((int) $seq + 1), 4, '0', STR_PAD_LEFT);
            $number = "{$prefix}-{$seq}-{$month}-{$year}";
            $attempts++;
        }
        return $number;
    }

    private static function sequential(string $prefix, string $model, string $column): string
    {
        $now = now();
        $month = $now->format('m');
        $year = $now->format('Y');
        $search = "{$prefix}-%-%-{$month}-{$year}";

        $count = $model::withTrashed()
            ->where($column, 'like', $search)
            ->count();

        $seq = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
        $number = "{$prefix}-{$seq}-{$month}-{$year}";

        $attempts = 0;
        while ($model::withTrashed()->where($column, $number)->exists() && $attempts < 50) {
            $seq = str_pad((string) ((int) $seq + 1), 4, '0', STR_PAD_LEFT);
            $number = "{$prefix}-{$seq}-{$month}-{$year}";
            $attempts++;
        }
        return $number;
    }
}
