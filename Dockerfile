# Install PHP dependencies in a throwaway stage so Composer isn't shipped.
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --ignore-platform-reqs

COPY . .
RUN composer dump-autoload --optimize --no-dev --no-interaction


FROM php:8.4-apache

# Render sends traffic to the port in $PORT (10000 by default).
ENV PORT=10000 \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

# Postgres driver for the hosted database.
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite \
    && sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
    && sed -ri 's!Listen 80!Listen ${PORT}!g' /etc/apache2/ports.conf \
    && sed -ri 's!<VirtualHost \*:80>!<VirtualHost *:${PORT}>!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=vendor /app /var/www/html

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

# Render's free plan sleeps after 15 minutes without visitors, and this service doesn't
# reliably wake back up. A background loop visits the public health check every 10 minutes
# so the site always has traffic and never falls asleep.
CMD ["sh", "-c", "php artisan config:cache && php artisan migrate --force && php artisan route:cache && php artisan view:cache && chown -R www-data:www-data storage bootstrap/cache && (while true; do sleep 600; curl -fsS -o /dev/null --max-time 60 \"${RENDER_EXTERNAL_URL:-https://https-nathaniel-meme-onrender-com.onrender.com}/up\" || true; done &) && apache2-foreground"]
