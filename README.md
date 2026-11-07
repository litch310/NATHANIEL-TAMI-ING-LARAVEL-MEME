# Nathaniel Tami-ing Laravel Meme

A small Laravel joke page made for Sir Zeus. Open the present (if you can catch it) to see how developers really use AI at 3 AM.

## Run locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

## Deploy

The included `Dockerfile` runs the app on Render's free web service. Set `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_DRIVER=cookie` and `CACHE_STORE=file` in the service's environment.
