#!/bin/bash

# Esperar a que la base de datos esté lista (máx. 60s)
echo "⏳ Esperando a la base de datos..."
timeout 60 bash -c 'until php artisan migrate:status > /dev/null 2>&1; do sleep 3; done'

# Ejecutar comandos Laravel
php artisan config:clear
php artisan migrate --seed --force
php artisan cache:clear

# Iniciar Apache
apache2-foreground
