# Mac Setup

Use this guide after cloning the repository onto your Mac.

## 1. Required Tools

Install these tools first:

- PHP 8.3 or newer
- Composer
- Node.js and npm
- MySQL
- Git

If you use Homebrew, this is a practical starting point:

```bash
brew update
brew install php composer node mysql git
brew services start mysql
```

## 2. Clone The Repository

```bash
git clone <repo-url>
cd <repo-folder>
```

## 3. Install PHP Dependencies

```bash
composer install
```

## 4. Install Frontend Dependencies

```bash
npm install
```

## 5. Create The Environment File

```bash
cp .env.example .env
```

## 6. Generate The App Key

```bash
php artisan key:generate
```

## 7. Create The MySQL Database

Open MySQL:

```bash
mysql -u root -p
```

Run this SQL:

```sql
CREATE DATABASE pdpa_internal_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then confirm these values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdpa_internal_app
DB_USERNAME=root
DB_PASSWORD=
```

If your local MySQL user or password is different on your Mac, update only those values in `.env`.

## 8. Run Migration And Seed

```bash
php artisan migrate:fresh --seed
```

## 9. Build Frontend Assets

```bash
npm run build
```

## 10. Run The Local Server

```bash
php artisan serve
```

Open:

- `http://127.0.0.1:8000`

## 11. Login Accounts

- `admin@pdpa.local` / `password`
- `staff@pdpa.local` / `password`
- `viewer@pdpa.local` / `password`

## 12. Common Mac Troubleshooting

### PHP not found

Check that PHP is installed and available in your shell:

```bash
php -v
which php
```

If needed, restart the terminal after installing PHP with Homebrew.

### Composer not found

Verify Composer:

```bash
composer -V
which composer
```

If it still is not found, make sure Homebrew binaries are on your `PATH`.

### MySQL connection refused

Check that MySQL is running:

```bash
brew services list
brew services start mysql
mysql --version
```

Then confirm the database credentials in `.env`.

### Permission issues

If Laravel cannot write cache or logs, fix permissions for the writable folders:

```bash
chmod -R u+rw storage bootstrap/cache
```

### npm build issues

Confirm versions first:

```bash
node -v
npm -v
```

Then reinstall dependencies and build again:

```bash
npm install
npm run build
```

## Clone-To-Run Command Summary

```bash
git clone <repo-url>
cd <repo-folder>
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```
