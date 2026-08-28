<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin user — credentials MUST be changed after first login.
        User::updateOrCreate(
            ['email' => 'admin@apc.local'],
            [
                'name' => 'APC Administrator',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
            ]
        );

        // Default expense categories
        $cats = [
            'Bahan',
            'Produksi',
            'Transportasi',
            'Operasional',
            'Marketing',
            'Packaging',
            'Lainnya',
        ];
        foreach ($cats as $c) {
            ExpenseCategory::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($c)], ['name' => $c]);
        }

        // Default FAQ
        $faqs = [
            [
                'q' => 'Apakah APC melayani pembelian individu?',
                'a' => 'Ya, APC melayani pembelian individu maupun pengadaan Instansi / Sekolah.',
                'order' => 1,
            ],
            [
                'q' => 'Bagaimana cara melakukan pemesanan?',
                'a' => 'Anda dapat menekan tombol "Pesan via WhatsApp" pada produk yang diinginkan, lalu admin kami akan membantu proses konsultasi dan pemesanan.',
                'order' => 2,
            ],
            [
                'q' => 'Apakah atribut dapat disesuaikan?',
                'a' => 'Ya. Ukuran, warna, dan desain dapat disesuaikan dengan kebutuhan Anda. Silakan konsultasikan via WhatsApp.',
                'order' => 3,
            ],
            [
                'q' => 'Berapa lama waktu pengerjaan?',
                'a' => 'Waktu pengerjaan tergantung kompleksitas dan jumlah pesanan. Estimasi akan diinformasikan setelah konsultasi.',
                'order' => 4,
            ],
            [
                'q' => 'Apakah ada minimal pemesanan?',
                'a' => 'Minimal pemesanan bervariasi per produk. Silakan tanyakan pada admin kami.',
                'order' => 5,
            ],
        ];
        foreach ($faqs as $f) {
            Faq::updateOrCreate(
                ['question' => $f['q']],
                ['answer' => $f['a'], 'sort_order' => $f['order'], 'is_published' => true]
            );
        }

        // Default static pages (content can be edited later)
        Page::updateOrCreate(
            ['slug' => 'tentang'],
            ['title' => 'Tentang APC', 'content' => '', 'is_published' => true]
        );
    }
}
