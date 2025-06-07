# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones requeridas por Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev libonig-dev curl git \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Copiar los archivos del proyecto al directorio de Apache
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias del proyecto Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajustes de permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Puerto expuesto por Apache
EXPOSE 80