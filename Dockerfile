# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Paquetes del sistema necesarios para compilar extensiones
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    libonig-dev \        # <- Oniguruma para mbstring
    pkg-config \         # <- para detección de libs
    unzip \
    curl \
    git \
 && docker-php-ext-install \
    bcmath \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Límites de subida
RUN printf "upload_max_filesize=50M\npost_max_size=50M\n" > /usr/local/etc/php/conf.d/uploads.ini

# Apache + .htaccess y DocumentRoot /public
RUN a2enmod rewrite \
 && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
 && sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && printf '<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>\n' >> /etc/apache2/sites-available/000-default.conf

# Copiar proyecto
WORKDIR /var/www/html
COPY . /var/www/html

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Dependencias PHP (producción)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Permisos
RUN mkdir -p storage/logs bootstrap/cache \
 && touch storage/logs/laravel.log \
 && chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

# start.sh ejecutable (asegúrate de LF, no CRLF)
RUN chmod +x /var/www/html/start.sh

EXPOSE 80
CMD ["./start.sh"]
