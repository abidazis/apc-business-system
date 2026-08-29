# APC Business Management System

End-to-end business management for **APC — Atribut Paskibra Cikarang**.

Includes a public marketing site (scroll-first one-page experience), full admin panel, sales workflow, finance, production kanban, and PDF invoicing.

## Tech Stack

- PHP 8.3
- Laravel 13
- Bootstrap 5.3 + Bootstrap Icons
- Vite (with Sass)
- MySQL 8 / MariaDB
- barryvdh/laravel-dompdf (PDF invoices)

## Quick Start (Development)

```bash
git clone <repo>
cd apc-system
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Visit:
- `http://localhost:8000` — public site
- `http://localhost:8000/admin/login` — admin login

## Production Deployment

See [DEPLOY.md](DEPLOY.md).

## Backup & Restore

See [BACKUP.md](BACKUP.md).

## Tests

```bash
php artisan test
npm run build
```

## Key Paths

| Concern | Location |
|---|---|
| Public site views | `resources/views/public/` |
| Admin views | `resources/views/admin/` |
| Public layouts | `resources/views/layouts/public.blade.php` |
| Admin layouts | `resources/views/layouts/admin.blade.php` |
| Brand settings | `app/Support/Settings.php` |
| WhatsApp helper | `app/Support/WhatsApp.php` |
| Number generator | `app/Models/NumberGenerator` |
| Design tokens | `resources/sass/app.scss` |
| Activity logger | `app/Services/Activity.php` |
| Backup command | `app/Console/Commands/BackupDatabase.php` |

## Documentation

- [DEPLOY.md](DEPLOY.md) — production deployment guide
- [BACKUP.md](BACKUP.md) — backup & restore procedures