#!/bin/bash
set -e

echo "⏳ Preparando SQLite..."
mkdir -p /var/www/html/database
[ -f /var/www/html/database/database.sqlite ] || touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "🧹 Limpiando caché de config..."
php artisan config:clear

echo "🔗 storage:link"
php artisan storage:link || true

echo "🗃️ Migraciones"
php artisan migrate --force || true
# php artisan db:seed --force || true  # si quieres seeds

echo "🧰 Cacheando config..."
php artisan config:cache

echo "🚀 Apache"
apache2-foreground
