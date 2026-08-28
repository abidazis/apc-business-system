# APC Business Management System

Sistem digital untuk bisnis **APC — Atribut Paskibra Cikarang**, terdiri dari:

1. **Public Website** — menampilkan produk, portfolio, dan CTA WhatsApp.
2. **Internal Admin System** — mengelola customer, lead, order, produksi, pembayaran, pengeluaran, invoice, dan laporan keuangan.

---

## Tech Stack

- **Laravel 13** (PHP 8.3)
- **MySQL / MariaDB**
- **Bootstrap 5.3** + Bootstrap Icons (compiled via Vite + Sass)
- **barryvdh/laravel-dompdf** untuk invoice PDF
- **Vanilla JavaScript** (no SPA / React / Vue)

Dirancang untuk **shared hosting murah**: tidak butuh Redis, Supervisor, Docker, atau Node runtime di server.

---

## Fitur Utama

### Public Website
- Homepage (hero, featured products, portfolio, why APC, CTA)
- Katalog produk + filter kategori + search
- Detail produk + WhatsApp CTA otomatis
- Portfolio publik + dokumentasi
- Halaman statis (Tentang, FAQ, Kontak)
- SEO (sitemap.xml, robots.txt, meta tags, OG tags)

### Admin
- Dashboard operasional + finance KPIs (omzet, payment in, piutang, HPP, expense, gross/net profit)
- **Product Management** (CRUD + upload gambar + kategori)
- **Customer & Lead Management**
- **Order Management** dengan workflow lengkap:
  - Lead → Quotation → Confirmed → DP Received → Design → Production → QC → Ready → Completed
  - Cancel tersedia
- **Production Kanban Board** (visual tracking per status, warning deadline)
- **Payment & Expense** tracking
- **Invoice PDF** (DomPDF) dengan format profesional
- **Portfolio Management** (admin CRUD + image gallery)
- **Settings** (nama bisnis, WhatsApp, logo, bank info, currency, dll — semua configurable, NO hardcode)
- **Reports** (revenue, expense, profit, top customer, top produk)
- **Role** (super_admin / admin / staff) dengan server-side Gate authorization

---

## Setup Lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate

# Configure DB di .env
php artisan migrate --seed
php artisan storage:link
npm run build

php artisan serve
```

Login: `admin@apc.local` / `password` (ubah setelah login pertama).

Lihat **[DEPLOY.md](DEPLOY.md)** untuk deployment ke shared hosting.

---

## Tests

```bash
php artisan test
```

28 automated tests mencakup: authentication, authorization, CRUD produk/customer/order/payment, kalkulasi order total, payment status, invoice number format, WhatsApp URL builder, public site rendering.

---

## Struktur

```
app/
├── Models/           # Eloquent models
├── Services/         # NumberGenerator, Formatter
├── Support/          # Settings, WhatsApp helpers
├── Http/
│   ├── Controllers/
│   │   ├── Public/   # Site publik
│   │   └── Admin/    # Dashboard, CRUD, finance
│   └── Requests/Admin/  # Form Request Validation
└── Providers/        # AppServiceProvider (Gate definitions)

database/
├── migrations/       # Schema (13 tables)
└── seeders/          # Default user + FAQ + expense categories

resources/
├── sass/app.scss     # Bootstrap + custom theme
└── views/
    ├── public/       # Public site
    ├── admin/        # Admin CRUD
    └── partials/     # Shared navbar, sidebar, etc.

routes/
├── web.php           # Public + admin
└── admin.php         # Admin area (auth required)

tests/Feature/        # 28 feature tests
```

---

## Nomor Penting

- **Order Number**: `ORD-0001-08-2026` (prefix-running-Bulan-Tahun)
- **Invoice Number**: `INV-0001-08-2026` (sesuai requirement: prefix-nomor urut-bulan-tahun)

---

## Lisensi

Proprietary — Internal APC.
