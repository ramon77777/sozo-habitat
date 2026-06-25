FROM php:8.3-cli

WORKDIR /var/www/html

# Dépendances système + drivers PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie du code
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Build des assets front-end
RUN npm install && npm run build

# Permissions storage
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

EXPOSE 10000

# Le migrate s'exécute ICI au démarrage, pas pendant le build
CMD php artisan migrate --force && php artisan config:clear && php artisan serve --host=0.0.0.0 --port=10000