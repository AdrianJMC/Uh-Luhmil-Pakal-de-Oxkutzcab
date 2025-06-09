# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones requeridas por Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev libonig-dev curl git \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Copiar los archivos del proyecto
COPY . /var/www/html

# Establecer directorio
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Crear archivo de log y asegurar permisos
RUN touch /var/www/html/storage/logs/laravel.log && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Establecer DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Hacer start.sh ejecutable
RUN chmod +x /var/www/html/start.sh

# Comando de inicio
CMD ["./start.sh"]

# Puerto
EXPOSE 80
