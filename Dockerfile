FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli \
 && a2enmod rewrite \
 && apt-get update && apt-get install -y --no-install-recommends libzip-dev zip unzip \
 && docker-php-ext-install zip \
 && rm -rf /var/lib/apt/lists/*

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/public/uploads \
 && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
