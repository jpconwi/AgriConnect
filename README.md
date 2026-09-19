# AgriConnect

A Laravel-based marketplace system connecting **farmers**, **suppliers**, and **buyers**, with an **admin** role for moderation, plus built-in payment recording and delivery tracking.

Built on the official Laravel 10 skeleton — this README covers everything added on top of it.

---

## Features

| Role | Capabilities |
|---|---|
| **Buyer** | Browse/search the marketplace, add items to cart, checkout (COD / GCash / Bank Transfer), view order history, track delivery status |
| **Farmer / Supplier** | Register (pending admin approval), list produce or farm inputs, manage/edit/delete own listings, view incoming orders for their products, update order status, mark payments as received |
| **Admin** | Approve/suspend farmer & supplier accounts, approve/reject product listings, manage categories, view all orders, update delivery status/tracking info |

**Core modules:** Auth & role-based access · Product catalog & categories · Cart & checkout · Orders & order items · Payments · Delivery tracking · Admin moderation dashboard.

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL (or SQLite for quick local testing)
- A machine with internet access (to run `composer install`, since packages are pulled from Packagist)

---

## Setup Instructions

1. **Install PHP dependencies**
   ```bash
   composer install
   ```

2. **Environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure the database** — open `.env` and either:
   - **Use MySQL** (default): create a database named `agri_connect` and fill in `DB_USERNAME` / `DB_PASSWORD`, or
   - **Use SQLite** (fastest for testing): change `.env` to
     ```
     DB_CONNECTION=sqlite
     ```
     and remove/comment the other `DB_*` lines, then:
     ```bash
     touch database/database.sqlite
     ```

4. **Run migrations and seed demo data**
   ```bash
   php artisan migrate --seed
   ```

5. **Link storage** (so uploaded product photos are viewable)
   ```bash
   php artisan storage:link
   ```

6. **Serve the app**
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000`.

---

## Demo Accounts (from the seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@agriconnect.test | password |
| Farmer (active) | farmer@agriconnect.test | password |
| Supplier (active) | supplier@agriconnect.test | password |
| Farmer (pending — for testing the approval flow) | pending.farmer@agriconnect.test | password |
| Buyer | buyer@agriconnect.test | password |

New farmer/supplier registrations start as **pending** and must be approved by the admin (Admin → Users) before they can log in. Buyer accounts are active immediately.

---

## How the System Fits Together

- **Registration & approval** — `AuthController` creates the user; farmers/suppliers get `status = pending` and are approved via `Admin\UserController`.
- **Listings & moderation** — sellers create products (`status = pending`); admins approve/reject via `Admin\ProductController`. Only `approved` products with stock show in the public marketplace.
- **Cart** — stored in the session (`CartController`), not the database, until checkout.
- **Checkout** — `OrderController@store` creates an `Order`, its `OrderItem`s, a `Payment` record, and a `Delivery` record in a single DB transaction, and decrements product stock.
- **Order fulfillment** — sellers update order status and mark payments as paid from **Sales / Orders**; admins can additionally update delivery status/tracking from **Admin → Orders**.
- **Delivery tracking** — buyers view a simple 3-stage tracker (Preparing → In Transit → Delivered) at `/orders/{order}/track`.

## Project Structure (what's custom vs. framework)

Everything under `app/`, `database/migrations`, `database/seeders/DatabaseSeeder.php`, `routes/web.php`, and `resources/views` (except the default `resources/views/welcome.blade.php`, which was removed) is custom for AgriConnect. Everything else (`config/`, `bootstrap/`, `public/index.php`, etc.) is the standard Laravel 10 skeleton.

## Suggested Next Steps for Your Defense

- Add automated tests (`tests/Feature`) covering registration approval, checkout, and role-based access.
- Add real payment gateway integration (currently payments are recorded manually/simulated).
- Add email/SMS notifications for order status changes.
- Add a reviews/ratings module for sellers.
