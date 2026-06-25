FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    && docker-php-ext-install pdo_mysql pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views

RUN touch database/database.sqlite

RUN php artisan storage:link || true

RUN php artisan migrate --force

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000