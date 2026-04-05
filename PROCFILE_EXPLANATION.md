# Railway Build Configuration for Laravel

This file `Procfile` is used by Railway/Heroku to start the application.

## Components

- **Procfile**: Starts the Heroku PHP buildpack with Nginx
- **nginx.conf**: Nginx configuration for routing all requests through index.php
- **composer.json**: Includes configuration for the Heroku buildpack

## How it Works

1. **Build Phase** (via custom build command):

    ```bash
    composer install --no-dev --optimize-autoloader && php artisan config:clear && php artisan config:cache && php artisan migrate --force && php artisan storage:link
    ```

2. **Start Phase** (via Procfile):
    ```bash
    vendor/bin/heroku-php-nginx -C ./nginx.conf public/
    ```

This uses:

- **Heroku PHP buildpack** with Nginx
- **FPM (FastCGI Process Manager)** for PHP
- **Nginx** as the web server
- Production-grade setup

## Why This Works Better

✅ Proper production environment  
✅ Nginx handles all HTTP routing  
✅ PHP-FPM for concurrent requests  
✅ No development server limitations  
✅ Compatible with Railway platform

## Local Development

For local development, use:

```bash
php artisan serve
```

For production testing locally:

```bash
vendor/bin/heroku-php-nginx -C ./nginx.conf public/
```

## Troubleshooting

If deployment still fails:

1. Check Rails logs: `railway logs --follow`
2. Verify build command runs successfully
3. Check PHP extensions are installed
4. Verify database credentials
