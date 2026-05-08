# Local Setup

This document describes the current Windows-based development setup for the Laravel PDPA project located at `C:\Users\DELL\LEARNING`.

## Validated Environment

The following commands were verified successfully on `2026-05-08`:

- `php -v` -> PHP 8.4.21
- `composer -V` -> Composer 2.9.5
- `laravel --version` -> Laravel Installer 5.25.1
- `mysql --version` -> MySQL 8.4.8
- `node -v` -> Node.js 24.15.0
- `npm -v` -> npm 11.12.1

## Project Health Checks

The current project passed these checks:

- `php artisan route:list`
- `php artisan migrate:status`
- `npm run build`

## Local Run Commands

Run everything from:

```powershell
cd C:\Users\DELL\LEARNING
```

Install dependencies if needed:

```powershell
composer install
npm install
```

Create the environment file if needed:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Use a MySQL database named `pdpa_internal_app`, then run:

```powershell
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Application URL:

- `http://127.0.0.1:8000`

## Seeded Login Accounts

- `admin@pdpa.local` / `password`
- `staff@pdpa.local` / `password`
- `viewer@pdpa.local` / `password`

## Important Local Notes

- `.env` is local-only and ignored by Git.
- `vendor/`, `node_modules/`, `database/database.sqlite`, and `storage/logs/laravel.log` are ignored by Git.
- Frontend assets can be rebuilt with `npm run build`.

## Useful Commands

```powershell
php artisan route:list
php artisan migrate:status
php artisan config:clear
php artisan cache:clear
php artisan serve
npm run build
```

## Windows Troubleshooting

### PHP not found

If `php` is not available, open the terminal that is configured with Laravel Herd or add your PHP installation to `PATH`.

### Composer not found

Confirm Composer is installed and available from the same shell where `php` works:

```powershell
composer -V
```

### MySQL connection issue

Verify MySQL is running, then confirm the matching values in `.env`:

- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=pdpa_internal_app`
- `DB_USERNAME=root`

### Frontend build issue

Reinstall dependencies and rebuild:

```powershell
npm install
npm run build
```
