# Genesis Goodhope Population Health Website & Booking Management System

A modern, responsive, and professional healthcare website and booking management system developed for **Genesis Goodhope Population Health**, a health and wellness organization based in Harare, Zimbabwe.

## Features
- **Public Website**: Includes Home, About Us, Services, Blog, Testimonials, and Contact Us pages.
- **WhatsApp Integration**: Floating WhatsApp chat widget linking to the Harare support line.
- **Booking Management System**: Easy-to-use multi-step interactive booking form allowing patients to reserve slots.
- **Patient Portal**: Private dashboard for registered patients to manage their profiles, view upcoming and past appointments, check doctor/staff feedback, and request cancellations.
- **Admin & Staff Portals**: Comprehensive dashboards featuring:
  - Analytics visual representations (Booking growth, status distribution, and popular services via Chart.js).
  - Appointment approval, completion, and feedback logging.
  - Patient directory and profile management.
  - Services CRUD management.
  - Blog and testimonials CRUD.
  - Settings manager for dynamic site configuration.
  - CSV report exports and minimalist print-optimized invoice views.

## Technology Stack
- **Framework**: Laravel 12
- **Language**: PHP 8.3+
- **Database**: SQLite Database
- **Styling**: Tailwind CSS
- **Authentication**: Laravel Breeze
- **Charts**: Chart.js

## Getting Started

### Prerequisites
- PHP >= 8.3
- Composer
- Node.js & NPM
- SQLite3

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/kudakwasheH/Genesis-Hope.git
   cd Genesis-Hope
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Create the SQLite database:
   On Windows (PowerShell):
   ```powershell
   New-Item -ItemType File -Path database/database.sqlite
   ```

5. Run migrations & seed data:
   ```bash
   php artisan migrate --seed
   ```

6. Build assets:
   ```bash
   npm run build
   ```

7. Start the local server:
   ```bash
   php artisan serve
   ```
   Open `http://127.0.0.1:8000` in your browser.

### Seeded Credentials
- **Admin**: `admin@genesis.org.zw` / `password123`
- **Staff**: `staff@genesis.org.zw` / `password123`
- **Patient**: `patient@genesis.org.zw` / `password123`

## Testing
To run the automated feature test suite:
```bash
php artisan test
```

## Contact
- **Organization**: Genesis Goodhope Population Health
- **Location**: Harare, Zimbabwe
- **Phone**: 071 216 2369
