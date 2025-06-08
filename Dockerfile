# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones requeridas por Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev libonig-dev curl git \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

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

# Establecer el DocumentRoot a /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Ajustes de permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Ejecutar migraciones y seeders con fuerza
RUN php artisan config:clear \
    && php artisan migrate --seed --force \
    && php artisan cache:clear

# Puerto expuesto por Apache
EXPOSE 80
