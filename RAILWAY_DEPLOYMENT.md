# Railway Deployment Guide

This document contains best practices and configurations to prevent crashes when deploying this Laravel application on Railway.

## Issues Fixed

### 1. ✅ Missing `app-layout` Component

**Problem**: The error `Unable to locate a class or view for component [app-layout]` was occurring during view caching.

**Solution**:

- The `AppLayout` component class now safely handles the view lookup
- The `AppServiceProvider` has been configured to handle deployment edge cases gracefully

### 2. ✅ Public Storage Symlink Error

**Problem**: The error `The [public/storage] link already exists` was crashing the application.

**Solution**:

- The `AppServiceProvider::handleStorageSymlink()` method now checks if the symlink already exists before trying to create it
- Errors during symlink creation are caught and ignored silently, as this is common in containerized environments

## Railway Configuration Checklist

### Environment Variables (.env)

Make sure these are set in your Railway environment:

```
APP_NAME=YourAppName
APP_ENV=production
APP_KEY=base64:xxxxx (generate with `php artisan key:generate`)
APP_DEBUG=false
APP_URL=https://your-railway-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

# Mail (if configured)
MAIL_DRIVER=log
MAIL_FROM_ADDRESS=noreply@example.com
```

### Procfile for Railway

Create a `Procfile` in the root directory:

```
web: vendor/bin/heroku-php-apache2 public/
```

Or if using Nginx, use Railway's built-in PHP support.

### Build Steps (Railway config)

In your Railway project settings, set up the build command:

```bash
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

Note: **Do NOT use** `php artisan view:cache` as it may fail if all components aren't properly resolved. Views will still be optimized.

### Start Command

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

Or for production-ready setup:

```bash
php artisan migrate --force && vendor/bin/heroku-php-apache2 public/
```

## Common Deployment Issues and Solutions

### Issue: "Unable to locate class or view for component"

✅ **Fixed** - The `AppServiceProvider` now safely handles missing components during boot.

**Prevention**:

- Ensure all Blade components are properly registered
- Use kebab-case for component names (`<x-app-layout>`)
- Keep component classes in `app/View/Components/`

### Issue: "The [public/storage] link already exists"

✅ **Fixed** - The `handleStorageSymlink()` method now checks for existing symlinks before creating new ones.

**Prevention**:

- Never manually create the symlink on Railway
- Let the application handle it during boot
- Don't include `public/storage` in your Git repository

### Issue: View Caching Failures

**Solution**:

- Avoid using `php artisan view:cache` in your build process
- The application uses file-based caching which works better with ephemeral filesystems
- Laravel's view compilation is automatic and safe

### Issue: File Permissions

**Solution**:

- Railway runs containers with proper permissions by default
- The application handles directory creation automatically
- Storage and bootstrap cache directories are created at runtime

## Deployment Process

1. **Prepare code**:

    ```bash
    git add .
    git commit -m "Ready for Railway deployment"
    ```

2. **Connect to Railway**:
    - Push to your GitHub repository
    - Connect Railway to your GitHub repo
    - Deploy from the Railway dashboard

3. **Set Environment Variables**:
    - Go to Railway project settings
    - Add all required `.env` variables
    - Restart deployment

4. **Monitor Logs**:
    ```bash
    railway logs
    ```

## What NOT to Do

❌ **Do NOT** commit `.env` file to Git
❌ **Do NOT** manually create the `public/storage` symlink
❌ **Do NOT** use `php artisan view:cache` in deployment
❌ **Do NOT** modify `AppServiceProvider::handleStorageSymlink()` method
❌ **Do NOT** commit `bootstrap/cache/` or `storage/` directories (except migrations)
❌ **Do NOT** disable error handling in `AppServiceProvider`

## Testing Before Deployment

### Local Testing

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Set to production mode
APP_ENV=production php artisan serve
```

### Check for Missing Views/Components

```bash
php artisan tinker
# Then run:
> view('layouts.app')
> view('layouts.navigation')
```

## Troubleshooting

If deployment still fails:

1. **Check Railway logs**:

    ```bash
    railway logs --follow
    ```

2. **Common patterns in logs**:
    - `Unable to locate class or view for component` → Verify component paths
    - `No such file or directory` → Check file permissions
    - `SQLSTATE[HY000]` → Verify database credentials in `.env`

3. **Rebuild and redeploy**:
    - Go to Railway dashboard
    - Click "Redeploy"
    - Check logs in real-time

## Useful Commands for Production

```bash
# SSH into Railway container
railway shell

# Run migrations
php artisan migrate --force

# Create cache tables
php artisan cache:table
php artisan sessions:table

# Check application status
php artisan up

# View recent logs
tail -f storage/logs/laravel.log
```

## Additional Resources

- [Railway Documentation](https://docs.railway.app/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [PHP on Railway](https://docs.railway.app/guides/php)

---

**Last Updated**: April 5, 2026
**Application**: IQBAL E-Commerce
