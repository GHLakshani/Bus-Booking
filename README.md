# BusGoes – Bus Seat Booking & GPS Tracking System

A web-based bus seat booking system with real-time GPS tracking, built with Laravel 13. Passengers can search routes, book seats, and track their bus live on a map. Admins manage schedules, bookings, users, and send delay notifications.

**Developed by:** S Lakshan Basnayake (BSC/WE/22/37/02) – SIBA Campus

---

## Table of Contents

- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Default Admin Account](#default-admin-account)
- [User Guide](#user-guide)
- [Admin Guide](#admin-guide)
- [GPS Tracking API](#gps-tracking-api)
- [Project Structure](#project-structure)
- [Tech Stack](#tech-stack)

---

## System Requirements

| Requirement | Version |
|---|---|
| PHP | 8.2 or higher |
| Composer | 2.x |
| MySQL | 5.7 or higher |
| Web Server | Apache (WAMP / XAMPP) or Nginx |
| Node.js (optional) | 18+ for asset building |

---

## Installation

### Step 1 – Clone the repository

```bash
git clone https://github.com/GHLakshani/Bus-Booking.git
cd Bus-Booking
```

### Step 2 – Install PHP dependencies

```bash
composer install
```

### Step 3 – Copy the environment file

```bash
cp .env.example .env
```

### Step 4 – Generate the application key

```bash
php artisan key:generate
```

### Step 5 – Create the database

Open **phpMyAdmin** (or your MySQL client) and create a new database:

```sql
CREATE DATABASE bus_booking_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 6 – Configure your environment

Open `.env` and update the following values:

```env
APP_NAME="BusGoes"
APP_URL=http://localhost/Bus-Booking/public

DB_DATABASE=bus_booking_laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
```

> **Gmail App Password:** Go to your Google Account → Security → 2-Step Verification → App Passwords. Generate a password for "Mail" and paste it as `MAIL_PASSWORD`.

### Step 7 – Run migrations and seed the database

```bash
php artisan migrate --seed
```

This creates all tables and the default admin account.

### Step 8 – Set storage permissions (Linux/Mac only)

```bash
chmod -R 775 storage bootstrap/cache
```

---

## Configuration

### WAMP / XAMPP Setup

If you are using WAMP or XAMPP, place the project inside the `www` or `htdocs` folder and access it at:

```
http://localhost/Bus-Booking/public
```

If you see URL issues (CSS not loading, routes broken), make sure `APP_URL` in `.env` matches your actual URL.

### MySQL 5.7 Compatibility

The project includes a fix for MySQL 5.7 key length limits. This is already applied in `app/Providers/AppServiceProvider.php` — no action needed.

### Session Driver

Sessions are stored in the database (`SESSION_DRIVER=database`). The `sessions` table is created automatically by `php artisan migrate`.

---

## Running the Application

### Option A – Via WAMP/XAMPP (recommended for Windows)

Start WAMP/XAMPP and open:
```
http://localhost/Bus-Booking/public
```

### Option B – Laravel development server

```bash
php artisan serve
```

Then open: `http://127.0.0.1:8000`

---

## Default Admin Account

After running `php artisan migrate --seed`, the following admin account is created:

| Field | Value |
|---|---|
| Email | `admin@busgoes.com` |
| Password | `admin@123` |

> **Important:** Change this password immediately after your first login.

To create additional admin accounts:
1. Register a new user at `/register`
2. Run the following command (replace the email):

```bash
php artisan tinker --execute="App\Models\User::where('email','user@example.com')->update(['user_type'=>'admin']);"
```

---

## User Guide

### Searching for Buses

1. Open the homepage at `/`
2. Select **From**, **To**, **Bus Type**, and **Date**
3. Click **Search Now**
4. Available buses are listed with fare and available seat count

### Booking Seats

1. From search results, click **Book Seats** on your preferred bus
2. The seat layout shows:
   - **Green** = available
   - **Blue** = selected by you
   - **Grey** = already booked
3. Click seats to select them
4. Click **Proceed Now**
5. A booking confirmation email is sent to your registered email

> You must be logged in to book. If not logged in, you will be redirected to the login page.

### Managing Bookings

Go to **My Account → My Bookings** to:
- View all your current and past bookings
- Cancel a confirmed booking (releases the seats back)

### Tracking a Bus

From search results, click **Track Bus** on any schedule to open the live GPS map. The map updates every **10 seconds** automatically.

### Password Reset

1. Click **Forgot Password** on the login page
2. Enter your registered email
3. Click the link sent to your email
4. Enter and confirm your new password

---

## Admin Guide

Access the admin panel at: `/admin/dashboard`

Log in with admin credentials — you are redirected to the dashboard automatically.

### Dashboard

Displays:
- Total bus schedules
- Total bookings
- Total registered users
- Last 5 bookings

### Bus Schedules

**View all schedules** → `/admin/buses`
- Search and sort via the DataTables interface
- Edit or delete any schedule

**Add a new schedule** → `/admin/buses/create`

Fill in:
- Schedule ID (unique identifier, e.g. `NE-COL-001`)
- Route From / To
- Departure time
- Bus model and depot name
- Fare (Rs.)
- Available seats (default 51)
- Duration, bus type, date
- Bus image (optional)

**Edit a schedule** → click **Edit** on the bus list

You can also update the **delay in minutes** directly from the edit form.

### View Bookings

View all passenger bookings across all schedules with full passenger and route details.

### Manage Users

View all registered users with their contact and location details.

### Notify Delay

1. Go to **Admin → Notify Delay**
2. Select the bus schedule
3. Enter the delay in minutes
4. Click **Notify**

All passengers with confirmed bookings on that schedule receive an email notification automatically. The delay is also displayed on the booking and tracking pages.

### Update GPS (Simulator)

Use this to manually set a bus location for testing:

1. Go to **Admin → Update GPS**
2. Select the bus schedule
3. Enter latitude and longitude (a reference table of Sri Lanka city coordinates is provided)
4. Click **Set**

The passenger tracking map reflects the update within 10 seconds.

### GPS API Tokens

Manage authentication tokens for real GPS devices:

1. Go to **Admin → GPS API Tokens**
2. Enter a label (e.g. `"Bus 101 GPS Device"`) and click **Generate Token**
3. **Copy the token immediately** — it is only shown once
4. Configure your GPS device or driver app to use this token (see GPS Tracking API section below)
5. Revoke tokens at any time by clicking **Revoke**

---

## GPS Tracking API

### Overview

The system exposes two API endpoints for GPS tracking:

| Endpoint | Method | Auth Required | Purpose |
|---|---|---|---|
| `/api/gps/update` | POST | Yes (X-GPS-Token) | GPS device sends live location |
| `/api/gps/{id}` | GET | No | Passenger map polls current location |

### Sending a GPS location update

A GPS device, driver mobile app, or any HTTP client sends:

```http
POST http://your-domain/api/gps/update
Content-Type: application/json
X-GPS-Token: your-token-here

{
  "bus_schedule_id": 1,
  "latitude": 6.9271,
  "longitude": 79.8612
}
```

**Success response:**
```json
{
  "success": true,
  "location": {
    "bus_schedule_id": 1,
    "latitude": "6.92710000",
    "longitude": "79.86120000",
    "updated_at": "2026-06-27T10:00:00.000000Z"
  }
}
```

**Error response (invalid token):**
```json
{
  "error": "Unauthorized. Invalid or missing API token."
}
```

### Reading the current bus location

The passenger tracking page calls this automatically every 10 seconds:

```http
GET http://your-domain/api/gps/1
```

**Response when location is available:**
```json
{
  "available": true,
  "latitude": "6.92710000",
  "longitude": "79.86120000",
  "updated_at": "2 minutes ago"
}
```

**Response when no location set:**
```json
{
  "available": false
}
```

### Integrating a real GPS device

Any device or app that can send HTTP POST requests can integrate with this system:

- **Hardware GPS tracker** – configure the server URL and add the `X-GPS-Token` header in the device settings
- **Driver mobile app** – use the Fetch API or any HTTP library to POST coordinates periodically
- **Postman / testing** – use the Postman collection to simulate GPS updates during development

### Sri Lanka City Coordinates (for testing)

| City | Latitude | Longitude |
|---|---|---|
| Colombo | 6.9271 | 79.8612 |
| Kandy | 7.2906 | 80.6337 |
| Galle | 6.0535 | 80.2210 |
| Jaffna | 9.6615 | 80.0255 |
| Matara | 5.9485 | 80.5353 |
| Anuradhapura | 8.3114 | 80.4037 |
| Badulla | 6.9934 | 81.0550 |

---

## Project Structure

```
Bus-Booking/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login, register, password reset
│   │   │   ├── BookingController.php     # Seat booking, my bookings, cancel
│   │   │   ├── BusScheduleController.php # Home, search, seat layout
│   │   │   ├── AdminController.php       # Admin CRUD, delay notify, API tokens
│   │   │   └── GpsController.php         # GPS tracking API + admin simulator
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php        # Blocks non-admin from /admin/*
│   │       └── ApiTokenMiddleware.php     # Protects GPS write API endpoint
│   └── Models/
│       ├── User.php          # SoftDeletes, isAdmin(), bookings()
│       ├── BusSchedule.php   # SoftDeletes, bookedSeatNumbers()
│       ├── Booking.php       # SoftDeletes
│       └── BusLocation.php   # SoftDeletes
├── database/
│   ├── migrations/           # All table definitions
│   └── seeders/
│       └── AdminSeeder.php   # Creates default admin account
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php     # User layout
│   │   └── admin.blade.php   # Admin layout with sidebar
│   ├── auth/                 # Login, register, forgot/reset password
│   ├── admin/                # All admin pages
│   │   ├── dashboard.blade.php
│   │   ├── bus-details.blade.php
│   │   ├── add-bus.blade.php
│   │   ├── edit-bus.blade.php
│   │   ├── view-bookings.blade.php
│   │   ├── manage-users.blade.php
│   │   ├── notify-delay.blade.php
│   │   ├── update-gps.blade.php
│   │   └── api-tokens.blade.php
│   ├── home.blade.php
│   ├── search-results.blade.php
│   ├── seat-booking.blade.php
│   ├── my-bookings.blade.php
│   ├── my-account.blade.php
│   └── track-bus.blade.php
├── routes/
│   ├── web.php               # All web routes
│   └── api.php               # GPS API routes
└── public/
    ├── css/                  # Bootstrap + custom styles
    ├── js/                   # jQuery, Bootstrap JS
    └── images/               # Logo, banners, UI images
```

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP 8.3) |
| Frontend | Laravel Blade, Bootstrap 5, jQuery |
| Database | MySQL 5.7+ with Eloquent ORM |
| Map / GPS | Leaflet.js + OpenStreetMap |
| Email | Laravel Mail (Gmail SMTP) |
| Session | Database-backed sessions |
| Architecture | Three-tier (Blade / Controllers / Models + MySQL) |

---

## Common Artisan Commands

```bash
# Run migrations and seed admin user
php artisan migrate --seed

# Re-run all migrations from scratch (WARNING: deletes all data)
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear

# Check all registered routes
php artisan route:list

# Open interactive PHP shell
php artisan tinker
```
