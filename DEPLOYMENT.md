# Deployment

This project is a Laravel application with Blade views and Vite assets.

## Recommended Production Setup

Use Railway for the real application because it needs PHP, Laravel routing, sessions, database access, webhooks, and server-rendered pages.

Vercel can only publish the Vite-built static assets from `public/build` unless the app is split into a separate frontend. The included `vercel.json` fixes Vercel's missing `dist` error by pointing it at `public/build`, but the usable app URL should be the Railway URL.

## Railway

1. Create a Railway project from the GitHub repository.
2. Add a MySQL database service.
3. Set these environment variables on the Laravel service.

Railway's MySQL plugin exposes variables like `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, and `MYSQLPASSWORD`. The app now reads those directly, so you can either attach/reference the MySQL variables or set the matching `DB_*` values manually.

```env
APP_NAME="طلبة"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.up.railway.app
ASSET_URL=https://your-railway-domain.up.railway.app
APP_KEY=base64:generate-this-with-php-artisan-key-generate

DB_CONNECTION=mysql

# Option A: use Railway MySQL variables directly
MYSQLHOST=${{MySQL.MYSQLHOST}}
MYSQLPORT=${{MySQL.MYSQLPORT}}
MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}
MYSQLUSER=${{MySQL.MYSQLUSER}}
MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}

# Option B: set Laravel DB variables instead
# DB_HOST=${{MySQL.MYSQLHOST}}
# DB_PORT=${{MySQL.MYSQLPORT}}
# DB_DATABASE=${{MySQL.MYSQLDATABASE}}
# DB_USERNAME=${{MySQL.MYSQLUSER}}
# DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=log

KASHIER_MID=your-kashier-mid
KASHIER_PAYMENT_KEY=your-kashier-payment-key
KASHIER_SECRET_KEY=your-kashier-secret-key
KASHIER_MODE=test
KASHIER_CURRENCY=EGP
KASHIER_CHECKOUT_URL=https://checkout.kashier.io
KASHIER_API_BASE_URL=https://test-fep.kashier.io
KASHIER_ALLOWED_METHODS=card,wallet
KASHIER_TIMEOUT=20

SMS_DRIVER=log
OTP_TTL_SECONDS=300
OTP_MAX_ATTEMPTS=3
OTP_DEBUG=false
```

For real SMS, change `SMS_DRIVER` to `twilio` or `vonage` and add the matching credentials.

4. Deploy. Railway will run the build command, then the start command in `railway.json`.

If you pasted a real database password into a chat or ticket, rotate/regenerate the MySQL password in Railway after the service is working.

## Vercel

If you still connect this repo to Vercel, the build creates a tiny `public/build/index.html` redirect page and `vercel.json` rewrites all requests to it:

- Framework preset: Other
- Build command: `npm run build`
- Output directory: `public/build`
- Redirect target: `https://talba.up.railway.app`

Vercel should not be treated as the Laravel runtime. It only forwards visitors to the Railway deployment where PHP, sessions, database access, and Kashier webhooks run.
