#!/bin/bash
set -e

echo "==> Fixing storage permissions..."
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chmod -R 777 storage bootstrap/cache

echo "==> Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "==> Setting up .env..."
# Always use the Docker-specific env inside the container
cp .env.docker .env

echo "==> Generating application key..."
php artisan key:generate --no-interaction

echo "==> Waiting for MySQL to be ready..."
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" &>/dev/null; do
    echo "   MySQL not ready yet — retrying in 2s..."
    sleep 2
done
echo "   MySQL is up."

echo "==> Running Laravel migrations..."
php artisan migrate --force --no-interaction

echo "==> Importing matchings data..."
# Only import if the table is empty (idempotent)
ROW_COUNT=$(mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" \
    -se "SELECT COUNT(*) FROM matchings;" 2>/dev/null || echo "0")
if [ "$ROW_COUNT" -eq "0" ]; then
    mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < database/matchings.sql
    echo "   Imported matchings.sql ($(mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -se 'SELECT COUNT(*) FROM matchings;') rows)."
else
    echo "   matchings table already has $ROW_COUNT rows — skipping import."
fi

echo "==> Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "==> Starting Apache..."
exec apache2-foreground
