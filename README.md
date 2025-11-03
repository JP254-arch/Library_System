# Laravel Library Management System (skeleton)

This ZIP contains a scaffold for a Laravel 10 Library Management System.

**Important steps after extracting:**

1. Install composer dependencies:
   ```
   composer install
   ```

2. Install node dependencies and build:
   ```
   npm install
   npm run dev
   ```

3. Copy .env and generate app key:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Create MySQL database `library_db` (or change .env), then migrate and seed:
   ```
   php artisan migrate --seed
   ```

**Seeded admin credentials**
- Email: admin@library.com
- Password: 12345678

Run the app:
```
php artisan serve
```
