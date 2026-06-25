FROM php:8.3-apache

WORKDIR /var/www/html

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

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

# Créer un .env minimal pour que Vite/Artisan puissent tourner pendant le build
RUN cp .env.example .env || true
RUN php artisan key:generate --force || true

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Build des assets front-end (Vite/Tailwind → public/build/)
RUN npm install && npm run build

# Permissions storage
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    && chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

# Pointer Apache sur le dossier public/ de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Render utilise le port 10000
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

# Au démarrage : écraser le .env par les vraies variables Render, migrer, lancer Apache
CMD bash -c "\
    echo APP_NAME=\$APP_NAME > .env && \
    echo APP_ENV=\$APP_ENV >> .env && \
    echo APP_KEY=\$APP_KEY >> .env && \
    echo APP_DEBUG=\$APP_DEBUG >> .env && \
    echo APP_URL=\$APP_URL >> .env && \
    echo DB_CONNECTION=\$DB_CONNECTION >> .env && \
    echo DB_HOST=\$DB_HOST >> .env && \
    echo DB_PORT=\$DB_PORT >> .env && \
    echo DB_DATABASE=\$DB_DATABASE >> .env && \
    echo DB_USERNAME=\$DB_USERNAME >> .env && \
    echo DB_PASSWORD=\$DB_PASSWORD >> .env && \
    php artisan config:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    apache2-foreground"