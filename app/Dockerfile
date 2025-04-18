FROM php:8.4

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql zip mbstring exif gd

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER www-data

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]