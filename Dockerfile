FROM php:8.3-cli


WORKDIR /var/www/html


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY . .


RUN composer install --no-dev --optimize-autoloader


RUN mkdir -p storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    bootstrap/cache


RUN touch database/database.sqlite


RUN php artisan storage:link || true


EXPOSE 10000


CMD php artisan serve --host=0.0.0.0 --port=10000