# Genesis Goodhope Population Health - Deployment Guide

This guide outlines the steps to deploy and run the Genesis Goodhope Population Health Website & Booking Management System.

---

## Prerequisites
Ensure the target server has the following dependencies installed:
1. **PHP 8.2+** (PHP 8.3+ recommended, PHP 8.5.5 supported)
   - Required extensions: `pdo_sqlite`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`.
2. **Composer 2.x**
3. **Node.js (v18+) & NPM**
4. **SQLite3**

---

## Local Setup & Installation

Follow these steps to initialize the application in a local development environment:

### 1. Clone or Extract Project
Make sure all project files are located in your target directory (e.g. `e:/MT31 SYSTEMS/genesis`).

### 2. Install Dependencies
Run the following commands to install Composer packages and Node modules:
```bash
composer install --no-interaction --optimize-autoloader
npm install
```

### 3. Environment Configuration
Copy the sample environment file to create your active `.env`:
```bash
cp .env.example .env
```
Ensure the database settings are configured for SQLite:
```env
DB_CONNECTION=sqlite
# DB_DATABASE is automatically generated as database/database.sqlite if left blank
```

### 4. Database Setup & Seeding
Run fresh migrations and seed the initial dataset (admin, staff, services, blogs, and settings):
```bash
php artisan migrate:fresh --seed
```

### 5. Compile Frontend Assets
Build production assets using Vite:
```bash
npm run build
```

### 6. Launch Application
Start the local development server:
```bash
php artisan serve
```
Access the application in your browser at: `http://127.0.5.1:8000` (or the address shown in your terminal).

---

## Seeded Authentication Accounts

You can log in to the portals immediately using these seeded accounts:

- **Administrator**:
  - Email: `admin@genesis.org.zw`
  - Password: `password123`
- **Staff (Doctor/Clinician)**:
  - Email: `staff@genesis.org.zw`
  - Password: `password123`
- **Patient/Customer**:
  - Email: `patient@genesis.org.zw`
  - Password: `password123`

---

## Production Deployment Checklist

If deploying to a live web server (e.g. Apache, Nginx, or cPanel):
1. **Set Environment to Production**:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
2. **Optimize Laravel Config & Routes**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. **Configure Storage Symlink**:
   Create a link so uploaded banner images are publicly accessible:
   ```bash
   php artisan storage:link
   ```
4. **Queue Worker**:
   Since `QUEUE_CONNECTION=database` is configured, set up a process manager (like Supervisor) to run the queue worker:
   ```bash
   php artisan queue:work
   ```
