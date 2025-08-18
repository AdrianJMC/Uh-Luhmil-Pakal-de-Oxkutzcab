#!/bin/bash
set -e

echo "🧹 Limpiando cachés..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "🔗 storage:link"
php artisan storage:link || true

wait_for_db() {
  local tries=30
  local host="${DB_HOST}"
  local port="${DB_PORT:-3306}"
  echo "⏳ Esperando a MySQL en $host:$port ..."
  until php -r '
    $h=getenv("DB_HOST"); $p=(int)(getenv("DB_PORT")?:3306);
    $t=@fsockopen($h,$p,$e1,$e2,2);
    if($t){ fclose($t); exit(0);} exit(1);
  '; do
    tries=$((tries-1))
    [ $tries -le 0 ] && echo "⚠️  Sin TCP aún; continuo igualmente." && break
    sleep 2
  done
}

RUN_MIGRATIONS="${RUN_MIGRATIONS:-1}"
RUN_SEEDERS="${RUN_SEEDERS:-0}"

echo "🔎 ENTORNO:"
echo "DB_CONNECTION=$DB_CONNECTION"
echo "DB_HOST=$DB_HOST"
echo "DB_PORT=$DB_PORT"
echo "DB_DATABASE=$DB_DATABASE"
echo "RUN_MIGRATIONS=$RUN_MIGRATIONS"
echo "RUN_SEEDERS=$RUN_SEEDERS"

wait_for_db

if [ "$RUN_MIGRATIONS" = "1" ]; then
  echo "🗃️ Migraciones"
  php artisan migrate --force --no-interaction
fi

if [ "$RUN_SEEDERS" = "1" ]; then
  echo "🌱 Seeders"
  php artisan db:seed --force --no-interaction
fi

echo "🧰 Cacheando..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "🚀 Apache"
exec apache2-foreground
