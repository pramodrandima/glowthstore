# Glowth Store (Laravel 11, Phase 1)

Production-ready Phase 1 digital product storefront for Glowth-only sales, built with Laravel 11, Blade + Tailwind, Filament v3, and Stripe Checkout.

## Features Included

- Public storefront: home, shop filters/search/sort, product detail pages
- Stripe Checkout payment flow (single-product purchase, no cart)
- Stripe webhook verification (`/webhooks/stripe`) as payment source of truth
- Orders, order items, and payment tracking
- Secure digital downloads with signed, expiring URLs and download event logs
- Customer account dashboard with order history and download history
- Filament admin for products, orders, customers, categories, tags
- Static pages: license, terms, privacy, support form
- Phase 2-ready schema fields (`owner_type`, `owner_id`, user roles including `vendor`)

## Tech Stack

- PHP 8.2+
- Laravel 11
- Blade + Tailwind
- Laravel Breeze (Blade auth)
- Filament v3
- Stripe SDK (`stripe/stripe-php`)
- Filesystem with local dev disk + S3-ready driver

## Local Setup

1. Install dependencies

```bash
composer install
npm install
```

2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Set these `.env` values (minimum):

```env
APP_NAME="Glowth Store"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite

MAIL_MAILER=log

STRIPE_KEY=pk_test_xxx
STRIPE_SECRET=sk_test_xxx
STRIPE_WEBHOOK_SECRET=whsec_xxx

PRODUCT_FILES_DISK=local
DOWNLOAD_EXPIRY_HOURS=24
DOWNLOAD_LIMIT=20
SUPPORT_EMAIL=support@glowthstore.test
```

3. Migrate + seed

```bash
php artisan migrate:fresh --seed
```

4. Build assets + run app

```bash
npm run build
php artisan serve
```

5. Filament admin login

- URL: `/admin`
- Seeded admin: `admin@glowthstore.test`
- Password: `password`

## Stripe Webhook (Local Testing)

1. Start Laravel app (`php artisan serve`).
2. In a new terminal, forward Stripe events with Stripe CLI:

```bash
stripe listen --forward-to http://127.0.0.1:8000/webhooks/stripe
```

3. Copy the shown webhook signing secret (`whsec_...`) into `.env` as `STRIPE_WEBHOOK_SECRET`.
4. Trigger a test checkout and confirm `checkout.session.completed` is received.

## Storage Configuration

- Product files are private (no public URLs).
- Downloads are served through app authorization and signed routes.
- `PRODUCT_FILES_DISK=local` in dev.
- For S3-compatible storage in production, configure:

```env
PRODUCT_FILES_DISK=s3
AWS_ACCESS_KEY_ID=...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=...
AWS_ENDPOINT=... # optional for S3-compatible providers
AWS_USE_PATH_STYLE_ENDPOINT=true # optional
```

## Testing

Run tests:

```bash
php artisan test
```

Added tests:

- Product page renders published product
- Checkout session creation with mocked Stripe checkout service
- Webhook signature rejection test

## Phase 2 Plan (Marketplace)

Already prepared in Phase 1:

- `products.owner_type` + `products.owner_id` for future vendor ownership
- `users.role` includes `admin`, `customer`, `vendor`
- Stripe logic isolated in `app/Services/Stripe/*` for future Stripe Connect extension

Planned for Phase 2:

- Vendor onboarding UI and vendor dashboards
- Vendor product management + moderation workflow
- Vendor payout routing via Stripe Connect
- Vendor-level analytics and support workflows
