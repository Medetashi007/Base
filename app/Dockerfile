FROM php:8.4

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql zip mbstring exif gd

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# laravelプロジェクトの新規作成
RUN mkdir -p src
WORKDIR /var/www/html/src
RUN composer create-project laravel/laravel .
WORKDIR /var/www/html

RUN composer require inertiajs/inertia-laravel && \
    php artisan inertia:middleware && \
    npm install @inertiajs/vue3 vue@3 @vitejs/plugin-vue

RUN npm install && npm run build && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage

USER www-data
