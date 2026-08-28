# Deployment Guide — APC Business Management System

Target deployment: **shared hosting murah** dengan PHP 8.2+ dan MySQL/MariaDB.

---

## 1. Local Setup

```bash
# Clone / download source
git clone <repo-url> apc-system
cd apc-system

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install frontend dependencies + build assets
npm install
npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apc_system
DB_USERNAME=...
DB_PASSWORD=...

# Migrate + seed (creates super admin)
php artisan migrate --force
php artisan db:seed --force

# Link storage
php artisan storage:link

# Local server
php artisan serve
```

Default super admin: **admin@apc.local / password**. Ubah setelah login pertama.

---

## 2. Environment Variables (Production)

Pastikan variabel berikut diisi di `.env` pada server:

```env
APP_NAME="APC - Atribut Paskibra Cikarang"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=apc_system
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```

---

## 3. Build Assets (Production)

Wajib build asset Vite **di local / build server**, lalu upload `public/build/`:

```bash
npm run build
```

Upload isi `public/build/` ke server. Production tidak menjalankan Vite — asset harus sudah tercompile.

---

## 4. Shared Hosting Deployment (cPanel / DirectAdmin)

### 4.1 Document Root
Arahkan **document root ke `public/`** (bukan root project). Contoh struktur di hosting:

```
/home/username/apc-system/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/         <- ini yang jadi document root
│   ├── index.php
│   ├── build/
│   └── ...
├── resources/
├── routes/
├── storage/
└── vendor/
```

Jika shared hosting tidak mengizinkan document root kustom, gunakan symlink atau `.htaccess` rewrite di root agar semua request diteruskan ke `public/`.

### 4.2 .htaccess di root (jika tidak bisa set document root)
Letakkan di root project:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 4.3 Set Permission
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/app storage/framework storage/logs
```

### 4.4 Storage Symlink
```bash
php artisan storage:link
```
Jika hosting tidak mendukung symlink, gunakan pendekatan `.htaccess` rewrite atau bind mount.

---

## 5. Optimize for Production

Jalankan di server setelah deploy:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

Untuk clear cache setelah update:
```bash
php artisan optimize:clear
```

---

## 6. Cron Jobs

Tambahkan cron berikut (tiap menit) untuk scheduled tasks (jika nanti ada notifikasi/cleanup):

```cron
* * * * * cd /home/username/apc-system && php artisan schedule:run >> /dev/null 2>&1
```

Untuk saat ini fitur inti **tidak bergantung** pada cron. Aplikasi dapat berjalan tanpa worker.

---

## 7. Database Backup

Buat script backup harian (mysqldump):

```bash
#!/bin/bash
DATE=$(date +%Y%m%d)
mysqldump -u DB_USER -pDB_PASS apc_system > /home/username/backups/apc_$DATE.sql
gzip /home/username/backups/apc_$DATE.sql

# Keep only last 30 days
find /home/username/backups/ -name "apc_*.sql.gz" -mtime +30 -delete
```

Jadwalkan via cron harian.

---

## 8. First Login Checklist

1. Login ke `https://yourdomain.com/admin/login`
2. Default: `admin@apc.local / password`
3. **Segera ubah password** (tambahkan user management atau langsung edit via database/seed)
4. Buka **Settings** → isi:
   - Business name, tagline, about
   - WhatsApp number (wajib — untuk tombol CTA)
   - Alamat, telepon, email, instagram, tiktok
   - Logo, hero image
   - Bank account info (untuk invoice)
   - Currency (default IDR/Rp)
5. Buka **Produk → Kategori**: tambahkan kategori (Seragam, Atribut, dll)
6. Tambahkan **Produk** pertama + upload gambar
7. (Opsional) Tambahkan **Portfolio** project pertama

---

## 9. Security Checklist (Production)

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] `.env` tidak ter-commit (sudah di `.gitignore`)
- [ ] Storage tidak dapat diakses langsung dari web (sudah dilindungi `.htaccess` Laravel)
- [ ] HTTPS aktif (Let's Encrypt / shared hosting SSL)
- [ ] Backup database harian aktif
- [ ] Super admin password sudah diganti dari default
- [ ] Login admin tidak terexpose di SEO (`robots.txt` sudah memblokir `/admin`)

---

## 10. Troubleshooting

### 500 setelah deploy
- Cek permission `storage/` & `bootstrap/cache/`
- Cek `APP_KEY` ter-generate
- Cek log di `storage/logs/laravel.log`

### Assets tidak muncul
- Pastikan `public/build/` ter-upload
- Jalankan `php artisan optimize:clear`

### Migration gagal
- Pastikan DB credentials benar
- Backup database dulu sebelum migrate
- Cek versi PHP minimal 8.2

### Sitemap 404
- `sitemap.xml` dihandle Laravel routing — jika hosting menggunakan Apache, pastikan `mod_rewrite` aktif dan `AllowOverride All`

---

## 11. Environment Reference

| Item            | Value                                              |
|-----------------|----------------------------------------------------|
| PHP             | 8.2+ (8.3 direkomendasikan)                        |
| Database        | MySQL 5.7+ / MariaDB 10.3+                         |
| Composer        | 2.x                                                |
| Node.js         | 18+ (hanya untuk build asset, tidak di production) |
| Web Server      | Apache/Nginx dengan mod_rewrite                   |
| Storage         | ~500 MB (tergantung foto produk & portfolio)       |
| Memory          | Minimum 256 MB PHP memory limit                    |

---

## 12. Support & Maintenance

- Update Laravel: `composer update`
- Update Bootstrap / icons: `npm update && npm run build`
- Test sebelum deploy: `php artisan test`
- Lihat log: `tail -f storage/logs/laravel.log`
