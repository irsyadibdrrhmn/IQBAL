# 🚀 Railway Deployment Quick Reference Card

## Pre-Deployment Checklist

```bash
# 1. Test locally first
php artisan cache:clear
php artisan config:clear
php artisan view:clear
APP_ENV=production php artisan serve

# 2. Make sure all changes are committed
git status
git add .
git commit -m "Ready for Railway deployment"

# 3. Push to GitHub
git push origin main
```

## Railway Environment Variables (REQUIRED)

Copy and paste these into Railway dashboard → Variables:

```
APP_NAME=IQBAL
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:5G8IFgeOeqPwN8IGgGMb7sd/lHC5lyqX1hR+8lcgY78=
APP_URL=https://your-railway-domain.com

DB_CONNECTION=sqlite
FILESYSTEM_DISK=local
CACHE_DRIVER=database
SESSION_DRIVER=database

LOG_CHANNEL=stack
LOG_LEVEL=debug

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@example.com

RAJAONGKIR_API_KEY=<your_api_key>
RAJAONGKIR_BASE_URL=https://api.rajaongkir.com/starter
```

## Custom Build Command

In Railway → Project Settings → Custom Build command, set:

```bash
composer install --no-dev --optimize-autoloader && php artisan config:clear && php artisan config:cache && php artisan migrate --force && php artisan storage:link
```

## Deployment

1. Connect your GitHub repo to Railway
2. Add all environment variables (see "Railway Environment Variables" section)
3. Set the custom build command (see "Custom Build Command" section)
4. Railway automatically detects `Procfile` and starts your app
5. Wait for build and deployment to complete

```bash
# Check status
railway logs --follow

# Run migrations (if needed)
railway run php artisan migrate --force

# Access your app
https://your-railway-domain.com
```

## Common Issues

| Issue                                                       | Solution                                                  |
| ----------------------------------------------------------- | --------------------------------------------------------- |
| `Unable to locate class or view for component [app-layout]` | ✅ Fixed - App now handles gracefully                     |
| `The [public/storage] link already exists`                  | ✅ Fixed - App checks before creating                     |
| Database connection errors                                  | Verify DB credentials in Variables                        |
| Page not found                                              | Run migrations: `railway run php artisan migrate --force` |
| Blank white page                                            | Check logs: `railway logs --follow`                       |

## Important Files

- `RAILWAY_DEPLOYMENT.md` - Full deployment guide
- `DEPLOYMENT_FIXES_SUMMARY.md` - What was fixed and why
- `Procfile` - How to start the app
- `railway.yml` - Railway configuration

## Files NOT to Commit

❌ `.env` (never!)
❌ `public/storage` (symlink)
❌ `storage/` (except migrations)
❌ `bootstrap/cache/`

---

**Ready to deploy!** All critical issues have been fixed. ✅
