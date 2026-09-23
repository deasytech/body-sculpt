# Body Sculpt Wellness

A premium Pilates, recovery, body sculpting and beauty studio platform for **Body Sculpt Wellness** (Lekki Phase 1, Lagos) — a full public marketing site, a Livewire booking engine, a customer account dashboard, and a Filament admin panel for running the business day-to-day.

## Tech Stack

**Backend**
- PHP 8.3+
- Laravel 13
- Laravel Fortify (authentication)

**Frontend / Interactivity**
- Livewire 4
- Livewire Flux (UI component library, used for the authenticated dashboard/settings screens)
- Alpine.js (lightweight client-side interactions on the public site)
- Tailwind CSS 4
- Vite (via `vite-plus`)

**Admin**
- Filament 5 — resources, dashboard widgets, and Setting-backed content pages for the public site's editable copy/images

**Database & Infrastructure**
- MySQL (production) / SQLite (local development & tests)
- Database-backed sessions, cache and queue

**Tooling**
- Pint — code style
- Larastan / PHPStan — static analysis
- PHPUnit — automated tests

## Features

- **Public site**: Home, About, Pilates, Wellness menu, Treatment detail pages, Membership, Café, Shop, Blog, Contact
- **Booking engine**: multi-step Livewire flow (service → date → time → customer details → confirmation) with double-booking prevention
- **Customer dashboard**: account details, membership status, upcoming/past appointments with self-service cancellation
- **Filament admin**: bookings, customers, staff/instructors/therapists, treatments, Pilates classes, memberships, products, orders, promo codes, blog, testimonials, FAQs, locations, newsletter subscribers, contact messages, and Setting-backed content editors for the Home/Café/About pages (edit headings and images from the backend — no code changes needed)
- **SEO**: per-page meta/Open Graph/Twitter cards, JSON-LD structured data (LocalBusiness, Service, Product, BlogPosting, FAQPage, BreadcrumbList), a dynamic `sitemap.xml` and `robots.txt`
- **cPanel-friendly deploy helpers**: token-protected routes to run `storage:link`, `optimize:clear` and `migrate` on hosts without SSH access (see [Deployment](#deployment))

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+ and npm
- MySQL (or SQLite for local development)

## Getting Started

```bash
git clone https://github.com/deasytech/body-sculpt.git
cd body-sculpt

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Edit `.env` and set at minimum:

| Variable | Purpose |
|---|---|
| `DB_*` | Database connection (defaults to SQLite — create `database/database.sqlite` and set `DB_CONNECTION=sqlite`, or configure MySQL) |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` | Credentials for the seeded Filament admin user — **required before seeding in production** |
| `DEPLOY_TOKEN` | Secret for the `/deploy/*` helper routes — generate with `php -r "echo bin2hex(random_bytes(32));"` |
| `MAIL_*` | Mail driver, for booking/contact notifications |
| `PAYMENT_DRIVER`, `PAYSTACK_SECRET_KEY`, `FLUTTERWAVE_SECRET_KEY` | Optional payment gateway config (booking works without payment configured) |

Then run migrations and seed demo content (treatments, Pilates classes, memberships, shop products, pages, and the admin user):

```bash
php artisan migrate --seed
```

Build front-end assets and start the app:

```bash
npm run build        # production build
# or, for local development:
composer run dev     # runs the dev server, queue worker and Vite together
```

Visit the site at your `APP_URL`, and the admin panel at `/admin` (log in with the `ADMIN_EMAIL`/`ADMIN_PASSWORD` you set above).

## Development

```bash
php artisan test              # run the test suite
vendor/bin/pint               # fix code style
vendor/bin/pint --test        # check code style without fixing
vendor/bin/phpstan analyse    # static analysis
```

## Deployment

The app is designed to run on a standard shared host (e.g. cPanel) without SSH access. After uploading a new build, hit these token-protected routes (using the `DEPLOY_TOKEN` set in that environment's `.env`) instead of a terminal:

```
https://yourdomain.com/deploy/storage-link?token=YOUR_DEPLOY_TOKEN
https://yourdomain.com/deploy/optimize-clear?token=YOUR_DEPLOY_TOKEN
https://yourdomain.com/deploy/migrate?token=YOUR_DEPLOY_TOKEN
```

Each is rate-limited and rejects requests without a valid token. Never reuse the same `DEPLOY_TOKEN` across environments.
