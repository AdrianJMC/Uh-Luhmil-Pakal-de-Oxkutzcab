#!/bin/bash

# Esperar a que la base de datos esté lista (máx. 60s)
echo "⏳ Esperando a la base de datos..."
timeout 60 bash -c 'until php artisan migrate:status > /dev/null 2>&1; do sleep 3; done'

# 🔧 Asegurar que el archivo de log exista y tenga permisos
echo "🛠️ Verificando archivo de log..."
mkdir -p storage/logs
touch storage/logs/laravel.log
chmod 664 storage/logs/laravel.log
chown www-data:www-data storage/logs/laravel.log

# 🔗 Crear enlace simbólico de storage
php artisan storage:link

# Ejecutar comandos Laravel
php artisan config:clear
php artisan migrate --seed --force
php artisan cache:clear

# Iniciar Apache
echo "🚀 Iniciando Apache..."
apache2-foreground