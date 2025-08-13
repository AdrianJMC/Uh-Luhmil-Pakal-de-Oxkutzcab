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

# 🔎 Diagnóstico de entorno y config reales
echo "🔎 Revisando entorno y config DB..."
echo "ENV DB_CONNECTION=$DB_CONNECTION"
echo "ENV DB_DATABASE=$DB_DATABASE"
php -r 'require "vendor/autoload.php"; $app=require "bootstrap/app.php"; $kernel=$app->make(Illuminate\Contracts\Console\Kernel::class); $kernel->bootstrap(); echo "CONFIG default=".config("database.default").PHP_EOL; echo "CONFIG sqlite.database=".config("database.connections.sqlite.database").PHP_EOL;'

echo "🗃️ Migraciones"
php artisan migrate --force || true
# php artisan db:seed --force || true

echo "🧰 Cacheando config..."
php artisan config:cache

echo "🚀 Apache"
apache2-foreground
