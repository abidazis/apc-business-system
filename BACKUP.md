# Backup & Restore Strategy

## Overview

APC uses **two** backup mechanisms:

1. **Automated daily SQL dump** via the `apc:backup` Artisan command
2. **Manual mysqldump** for ad-hoc snapshots before risky changes

Backups are stored in `storage/app/backups/` by default (configurable via `APC_BACKUP_PATH`).

## Automated Backup

The Laravel scheduler runs:

```bash
php artisan apc:backup --keep=10
```

at **02:00 server time** every day.

Output:
- File: `storage/app/backups/backup-YYYY-MM-DD-HHMMSS.sql` (on `local` disk → `storage/app/private/backups/`; on `public` disk → `storage/app/public/backups/`)
- Retention: 10 most recent files (older are pruned automatically)

### Changing Schedule or Retention

Edit `routes/console.php`:

```php
Schedule::command('apc:backup --keep=10')->dailyAt('02:00');
```

### Verifying It Works

```bash
php artisan apc:backup --keep=5
```

Expected output:

```
Backup written: backups/backup-2026-08-29-093045.sql (12.3 KB)
```

## Cron Wiring (Shared Hosting)

In cPanel → Cron Jobs:

```
0 2 * * * cd /home/user/apc-system && php artisan schedule:run >> /dev/null 2>&1
```

Adjust the path to your project location.

## Off-server Backup (Recommended)

The `storage/app/backups/` directory lives **on the same disk** as the application. If the disk fails, you lose both.

Add an off-server copy using one of:

- cPanel → Backup Wizard → automatic off-site copy
- A daily cron that uploads the latest `backup-*.sql` to S3, Google Drive, or Backblaze B2
- Your hosting provider's snapshot/backup service

**Minimum retention:** 7 daily + 4 weekly = at least 11 snapshots.

## Manual Snapshot Before Major Changes

```bash
php artisan apc:backup --keep=20
mysqldump -u apc_user -p apc_system > ~/manual-$(date +%Y%m%d).sql
```

## Restore Procedure

### From `apc:backup` SQL dump

```bash
# Drop and recreate database (CAUTION)
mysql -u root -p -e "DROP DATABASE apc_system; CREATE DATABASE apc_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Restore
mysql -u apc_user -p apc_system < storage/app/backups/backup-2026-08-29-093045.sql
```

### From manual mysqldump

```bash
mysql -u apc_user -p apc_system < manual-20260829.sql
```

### Verify after restore

```bash
php artisan tinker --execute="echo App\Models\Order::count();"
php artisan tinker --execute="echo App\Models\Payment::count();"
```

Numbers should match a known-good state.

## Storage (Image) Backups

The `storage/app/public/` directory contains all uploaded images (products, portfolio, settings). Back this up **separately** from the database — they are NOT in the SQL dump.

Add to your nightly backup routine:

```bash
tar -czf ~/storage-snapshot-$(date +%Y%m%d).tar.gz storage/app/public
```

Or use cPanel's File Manager to download the `storage/app/public/` folder periodically.

## What to Back Up

| Component | How Often | Where to Store |
|---|---|---|
| Database | Daily | Off-server (cloud / different disk) |
| `storage/app/public/` images | Weekly | Off-server |
| `.env` | On every change | Secure vault (1Password, Bitwarden) |
| Source code | On every release | Git remote |

## Disaster Recovery Checklist

If the server is lost or corrupted:

1. Spin up a fresh VPS / hosting account with the same PHP/MySQL versions
2. Upload the latest codebase (git clone or backup)
3. Restore `.env` from secure vault
4. `composer install --no-dev --optimize-autoloader`
5. `npm install && npm run build`
6. `php artisan migrate` (in case schema is behind)
7. Restore database from latest off-server backup
8. Restore `storage/app/public/` from latest image backup
9. `php artisan storage:link`
10. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
11. Update DNS / IP
12. Smoke test homepage, product page, admin login