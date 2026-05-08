# PDPA Internal App

Laravel-based internal application for managing PDPA-sensitive data subject records and rights requests. The project is designed as a learning-friendly codebase, so the repository includes setup guides and a 7-day roadmap for studying the architecture on another machine.

## What This Project Covers

- Authentication with Laravel Breeze
- Authorization with roles: `admin`, `staff`, `viewer`
- Data subject record management
- PDPA request tracking and status management
- Audit logging for create, update, and delete actions
- Data masking for viewer-level access
- Blade-based UI with Vite and Tailwind
- MySQL-backed Laravel application structure

## Request Flow To Study

The intended learning path for this codebase is:

`Route -> Middleware -> Controller -> FormRequest -> Service -> Model -> Database -> View`

The current app already contains controllers, models, policies, services, migrations, seeders, and Blade views. It also includes FormRequest classes that can be used as part of future refactoring and study exercises.

## Main Project Areas

- `app/Http/Controllers` for request handling
- `app/Http/Requests` for validation classes
- `app/Models` for Eloquent models
- `app/Policies` for authorization rules
- `app/Services` for audit logging and data masking
- `config/pdpa.php` for PDPA-specific configuration
- `database/migrations` for schema management
- `database/seeders` for local seed data
- `resources/views` for Blade templates
- `routes/web.php` for web routes

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create the database:

```sql
CREATE DATABASE pdpa_internal_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run:

```bash
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Seeded Login Accounts

- `admin@pdpa.local` / `password`
- `staff@pdpa.local` / `password`
- `viewer@pdpa.local` / `password`

## Repository Safety

This repository is prepared for GitHub transfer and does not commit local-only or sensitive artifacts such as:

- `.env`
- `vendor/`
- `node_modules/`
- `database/*.sqlite`
- `storage/logs/*.log`
- `public/build`
- Laravel cache output under `bootstrap/cache`

## Study And Setup Docs

- `LOCAL_SETUP.md` for the current Windows workflow
- `MAC_SETUP.md` for post-clone setup on macOS
- `LEARNING_ROADMAP.md` for the 7-day Laravel study plan plus a supplement that connects handwritten Laravel architecture notes to the real PDPA project structure and code flow

## Health Checks Completed On The Current Work Computer

- `php artisan route:list`
- `php artisan migrate:status`
- `npm run build`

All three completed successfully on `2026-05-08`.
