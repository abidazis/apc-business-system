# Deployment Guide — APC Business Management System

This guide covers deploying the APC system to a production shared-hosting environment.

## 1. Hosting Requirements

The application needs:

| Requirement | Minimum | Recommended |
|---|---|---|
| PHP | 8.3 | 8.3 (latest stable) |
| PHP extensions | BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, cURL, Fileinfo, GD or Imagick | + ZIP, + INTL |
| MySQL / MariaDB | MySQL 8.0 or MariaDB 10.6 | MySQL 8.x |
| Composer | 2.x | 2.x |
| Node.js (only for asset build) | 18+ | 20 LTS |
| SSH / terminal access | Yes (for `php artisan` commands) | Yes |
| Cron support | Yes | Yes |
| Web server | Apache or Nginx | Nginx |
| Document root customization | Yes (must point to `public/`) | Yes |

Most Indonesian shared-hosting providers (Niagahoster, IDCloudHost, Rumahweb, Biznet Gio) meet these requirements.

## 2. Local / Staging Prep

Before uploading:

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 2. Make sure these are committed but NOT containing secrets
.env.example
```

Do **NOT** commit `.env` itself.

## 3. Server Prep

```bash
# Create the database (in cPanel or via terminal)
mysql -u root -p
> CREATE DATABASE apc_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> CREATE USER 'apc_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
> GRANT ALL PRIVILEGES ON apc_system.* TO 'apc_user'@'localhost';
> FLUSH PRIVILEGES;
```

## 4. Upload Project

Upload all files **EXCEPT** these to the hosting root (e.g. `/home/user/apc-system`):

- `.git/`
- `node_modules/`
- `tests/`
- `.env` (you'll create a fresh one)
- `storage/framework/cache/*`
- `storage/framework/sessions/*`
- `storage/framework/views/*`
- `storage/logs/*`
- `public/build/` (will be regenerated)

A typical shared-hosting upload uses cPanel File Manager or SFTP. Keep the project in a folder **above** `public_html`:

```
/home/user/
├── apc-system/                  ← project root
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/                  ← document root target
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── ...
└── public_html/                 ← existing web root
    └── (replace with apc-system/public, OR symlink)
```

**Important:** The web server's document root MUST point to `apc-system/public/`. On shared hosting, this is usually done by:

- Setting document root in cPanel → MultiPHP → User Domain
- OR uploading `apc-system/public/*` contents into `public_html/`
- OR symlinking: `ln -s /home/user/apc-system/public /home/user/public_html`

## 5. .env Configuration

Create `.env` in project root:

```env
APP_NAME="APC"
APP_ENV=production
APP_KEY=                ← generate with: php artisan key:generate
APP_DEBUG=false
APP_URL=https://apc.example.com

LOG_CHANNEL=daily
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apc_system
DB_USERNAME=apc_user
DB_PASSWORD=STRONG_PASSWORD

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@apc.example.com"
MAIL_FROM_NAME="${APP_NAME}"

# APC custom
APC_BACKUP_PATH=backups
```

Then:

```bash
php artisan key:generate
```

## 6. Install + Migrate

```bash
# Composer install (server)
composer install --no-dev --optimize-autoloader

# Database migrations + seed (creates the first admin user)
php artisan migrate --force
php artisan db:seed --force
```

## 7. Storage Symlink

Required so uploaded images are web-accessible:

```bash
php artisan storage:link
```

This creates `public/storage → ../storage/app/public`.

## 8. Build Assets (already done locally OR on server)

If you did NOT build locally:

```bash
npm install --omit=dev
npm run build
```

## 9. Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R USER:USER storage bootstrap/cache
```

On shared hosting, both Apache and the SSH user must be able to write to those folders.

## 10. Cache Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If you ever need to clear them:

```bash
php artisan optimize:clear
```

## 11. Cron (Scheduler)

The system schedules **one** task — daily database backup at 02:00.

In cPanel → Cron Jobs, add:

```
0 2 * * * cd /home/user/apc-system && php artisan schedule:run >> /dev/null 2>&1
```

Adjust `/home/user/apc-system` to your real path.

The scheduled command runs `php artisan apc:backup --keep=10`, which writes a SQL dump to `storage/app/backups/` (configurable via `APC_BACKUP_PATH`) and prunes anything older than the keep count.

## 12. Backup Strategy

See section below or [BACKUP.md](BACKUP.md).

## 13. Post-Deploy Checks

- [ ] Visit `/` → homepage loads
- [ ] Visit `/admin/login` → login form loads
- [ ] Login with seeded credentials → dashboard loads
  - Default: `admin@apc.local` / `password` — CHANGE IMMEDIATELY via Settings → User
- [ ] Visit `/sitemap.xml` → contains URLs
- [ ] Visit `/robots.txt` → contains sitemap reference
- [ ] Upload an image in Admin → Settings (Hero) → verify on `/`
- [ ] Click WhatsApp CTA → opens wa.me with correct number from Settings
- [ ] Create a test order → invoice PDF downloads

## 14. Updating the App

```bash
# Pull latest
git pull origin main

# Update deps
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run new migrations (if any)
php artisan migrate --force

# Refresh cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting

**500 errors after deploy**

- Check `storage/logs/laravel.log`
- Verify `APP_DEBUG=false`
- Verify storage permissions

**Images not loading**

- Re-run `php artisan storage:link`
- Confirm `public/storage` exists and points to `storage/app/public`

**404 on admin routes**

- Clear route cache: `php artisan route:clear`
- Confirm web server rewrites are present (see below)

**Required Apache .htaccess in `public/`**

Laravel ships this. If missing:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Required Nginx config**

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```