# Client Portal

Laravel + MySQL web portal for a freelance marketing consultant and clients.

## Stack

- Laravel 12
- Blade + Tailwind CSS + Breeze authentication
- MySQL / MariaDB
- Public disk storage for task reference images

## Roles

- Admin creates client accounts, manages requests, and manages invoices.
- Client signs in, creates requests, uploads reference images, and views billing.

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create the database:

```sql
CREATE DATABASE client_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Demo accounts after seeding:

- Admin: `admin@clientportal.test` / `password`
- Client: `client@clientportal.test` / `password`

## Notes

- Public self-registration is disabled. Admins create client accounts from the Clients screen.
- Invoices are manual records; there is no payment gateway integration.
- Uploaded request images are stored on Laravel's `public` disk under `task-references`.
- For Vite 7, Node `20.19+` or `22.12+` is recommended.

