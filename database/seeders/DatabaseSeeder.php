<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ExpenseCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedUsers();
        $this->seedCategories();
        $this->seedExpenseCategories();
        $this->seedFaqs();
        $this->seedPages();
    }

    private function seedSettings(): void
    {
        $settings = [
            'business_short' => 'APC',
            'business_name' => 'Atribut Paskibra Cikarang',
            'tagline' => 'Perlengkapan Paskibra Berkualitas untuk Sekolah dan Organisasi',
            'about_short' => 'Solusi perlengkapan dan atribut Paskibra yang memahami kebutuhan sekolah, komunitas, dan event di seluruh Indonesia.',
            'whatsapp' => '6281234567890',
            'phone' => '021-1234567',
            'email' => 'info@atributpaskibracikarang.id',
            'address' => 'Cikarang, Bekasi, Jawa Barat, Indonesia',
            'instagram' => 'atributpaskibra',
            'tiktok' => 'atributpaskibra',
            'website_title' => 'APC - Atribut Paskibra Cikarang',
            'meta_description' => 'APC menyediakan perlengkapan dan atribut Paskibra berkualitas untuk sekolah dan organisasi. Konsultasi gratis via WhatsApp.',
        ];

        foreach ($settings as $key => $value) {
            Settings::set($key, $value);
        }
    }

    private function seedUsers(): void
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

        // Admin user
        User::updateOrCreate(
            ['email' => 'manager@apc.local'],
            [
                'name' => 'APC Manager',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
            ]
        );
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'Atribut Paskibra', 'description' => 'Seragam dan atribut resmi paskibra sekolah', 'sort_order' => 1],
            ['name' => 'Perlengkapan Upacara', 'description' => 'Bendera, tongkat, dan perlengkapan upacara bendera', 'sort_order' => 2],
            ['name' => 'Seragam Kegiatan', 'description' => 'Seragam untuk kegiatan-kegiatan khusus', 'sort_order' => 3],
            ['name' => 'Custom Produk', 'description' => 'Produk kustom sesuai kebutuhan sekolah/organisasi', 'sort_order' => 4],
            ['name' => 'Packaging & Aksesoris', 'description' => 'Tas, sampul, dan aksesoris pendukung', 'sort_order' => 5],
        ];

        foreach ($categories as $cat) {
            $slug = Str::slug($cat['name']);
            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedExpenseCategories(): void
    {
        $cats = [
            'Bahan Baku',
            'Produksi',
            'Transportasi',
            'Operasional',
            'Marketing',
            'Packaging',
            'Gaji & Honorer',
            'Listrik & Utilitas',
            'Lainnya',
        ];
        foreach ($cats as $c) {
            ExpenseCategory::firstOrCreate(
                ['slug' => Str::slug($c)],
                ['name' => $c]
            );
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question' => 'Apakah APC melayani pembelian individu?',
                'answer' => 'Ya, APC melayani pembelian individu maupun pengadaan untuk Instansi, Sekolah, dan Organisasi. Kami siap membantu kebutuhan Anda.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Bagaimana cara melakukan pemesanan?',
                'answer' => 'Anda dapat memilih produk yang diinginkan, lalu tekan tombol "Chat WhatsApp" untuk konsultasi langsung dengan tim kami. Kami akan membantu proses konsultasi dan pemesanan hingga selesai.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Apakah atribut dapat disesuaikan dengan kebutuhan sekolah?',
                'answer' => 'Ya, tentu. Ukuran, warna, logo/logo sekolah, dan desain dapat disesuaikan dengan kebutuhan dan identitas sekolah Anda. Silakan konsultasikan via WhatsApp.',
                'sort_order' => 3,
            ],
            [
                'question' => 'Berapa lama waktu pengerjaan?',
                'answer' => 'Waktu pengerjaan bervariasi tergantung kompleksitas desain, jumlah pesanan, dan musim (menjelang 17 Agustus biasanya lebih sibuk). Estimasi waktu akan diinformasikan setelah konsultasi.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Apakah ada minimal pemesanan?',
                'answer' => 'Minimal pemesanan bervariasi tergantung produk. Untuk pengadaan sekolah/organisasi biasanya dimulai dari 10-25 unit. Silakan tanyakan pada tim kami untuk informasi lebih lanjut.',
                'sort_order' => 5,
            ],
            [
                'question' => 'Apakah bisa desain/logo sekolah kami dicetak?',
                'answer' => 'Ya, kami dapat mencetak desain dan logo sekolah Anda. Anda dapat kirimkan file desain dalam format AI, PSD, CDR, atau PDF, atau tim kami bisa membantu desain ulang dengan biaya tambahan.',
                'sort_order' => 6,
            ],
            [
                'question' => 'Bagaimana sistem pembayarannya?',
                'answer' => 'Pembayaran dapat dilakukan via transfer bank. Biasanya menggunakan sistem DP (Down Payment) 50% dan pelunasan sebelum pengiriman. Detail pembayaran akan diinformasikan saat konfirmasi pesanan.',
                'sort_order' => 7,
            ],
        ];
        foreach ($faqs as $f) {
            Faq::updateOrCreate(
                ['question' => $f['question']],
                [
                    'answer' => $f['answer'],
                    'sort_order' => $f['sort_order'],
                    'is_published' => true,
                ]
            );
        }
    }

    private function seedPages(): void
    {
        // About/Tentang page
        Page::updateOrCreate(
            ['slug' => 'tentang'],
            [
                'title' => 'Tentang APC - Atribut Paskibra Cikarang',
                'content' => '<h2>Mitra Tepercaya untuk Kebutuhan Paskibra</h2>
<p>APC adalah solusi perlengkapan dan atribut Paskibra yang memahami kebutuhan sekolah, komunitas, dan event di seluruh Indonesia. Dengan pengalaman dan fokus pada kualitas, kami membantu tim Paskibra tampil maksimal di setiap kesempatan.</p>

<h3>Visi Kami</h3>
<p>Menjadi mitra utama perlengkapan Paskibra yang terpercaya untuk sekolah-sekolah di Indonesia, dengan komitmen pada kualitas produk, harga yang terjangkau, dan layanan konsultasi yang prima.</p>

<h3>Misi Kami</h3>
<ul>
<li>Menyediakan produk atribut Paskibra berkualitas dengan harga terjangkau</li>
<li>Memberikan konsultasi gratis untuk membantu sekolah memilih produk yang tepat</li>
<li>Memastikan kualitas melalui proses quality control yang ketat</li>
<li>Mengirim pesanan tepat waktu sesuai jadwal yang disepakati</li>
</ul>

<h3>Kenapa Memilih APC?</h3>
<ul>
<li><strong>Spesialis Paskibra</strong> — Fokus pada atribut dan perlengkapan Paskibra sekolah</li>
<li><strong>Bisa Custom</strong> — Desain, ukuran, dan logo sekolah dapat disesuaikan</li>
<li><strong>Konsultasi Gratis</strong> — Tim kami siap membantu via WhatsApp</li>
<li><strong>Melayani Instansi</strong> — Pengadaan dalam jumlah besar untuk sekolah/organisasi</li>
<li><strong>Quality Control</strong> — Setiap pesanan melewati proses QC sebelum dikirim</li>
<li><strong>Pengiriman Tepat Waktu</strong> — Komitmen untuk deliver sesuai jadwal</li>
</ul>

<p>Hubungi kami sekarang untuk konsultasi kebutuhan atribut Paskibra sekolah Anda!</p>',
                'is_published' => true,
            ]
        );

        // Contact page
        Page::updateOrCreate(
            ['slug' => 'kontak'],
            [
                'title' => 'Hubungi Kami',
                'content' => '<h2>Hubungi APC</h2>
<p>Tim kami siap membantu kebutuhan atribut Paskibra Anda. Silakan hubungi kami via WhatsApp untuk konsultasi gratis!</p>
<p>Respon tercepat melalui WhatsApp. Kami biasanya membalas dalam hitungan menit selama jam kerja.</p>',
                'is_published' => true,
            ]
        );
    }
}
