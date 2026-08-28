<?php

namespace App\Support;

use App\Models\Product;

class WhatsApp
{
    /**
     * Build a wa.me link with a pre-filled message.
     * The number is sourced from Settings (not hardcoded).
     */
    public static function url(?string $message = null): string
    {
        $number = Settings::whatsappNumber();
        $base = 'https://wa.me/' . $number;
        if ($message) {
            $base .= '?text=' . rawurlencode($message);
        }
        return $base;
    }

    public static function messageForProduct(Product $product): string
    {
        $business = Settings::get('business_short', 'APC');
        return "Halo {$business}, saya tertarik dengan produk {$product->name}.\n\nSaya ingin menanyakan harga dan detail produknya. Mohon informasinya, terima kasih.";
    }

    public static function messageGeneral(): string
    {
        $business = Settings::get('business_short', 'APC');
        return "Halo {$business}, saya ingin berkonsultasi mengenai kebutuhan Paskibra. Mohon informasinya, terima kasih.";
    }

    public static function messageForOrder(string $orderNumber): string
    {
        $business = Settings::get('business_short', 'APC');
        return "Halo {$business}, saya ingin menanyakan progress pesanan dengan nomor {$orderNumber}. Terima kasih.";
    }
}
