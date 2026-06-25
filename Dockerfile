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

# .env minimal pour le build (Vite + Artisan)
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

# Au démarrage : écrire le .env avec les variables Render (guillemets pour gérer les espaces)
CMD bash -c "\
    printf 'APP_NAME=\"%s\"\n' \"\$APP_NAME\" > .env && \
    printf 'APP_ENV=\"%s\"\n' \"\$APP_ENV\" >> .env && \
    printf 'APP_KEY=\"%s\"\n' \"\$APP_KEY\" >> .env && \
    printf 'APP_DEBUG=\"%s\"\n' \"\$APP_DEBUG\" >> .env && \
    printf 'APP_URL=\"%s\"\n' \"\$APP_URL\" >> .env && \
    printf 'DB_CONNECTION=\"%s\"\n' \"\$DB_CONNECTION\" >> .env && \
    printf 'DB_HOST=\"%s\"\n' \"\$DB_HOST\" >> .env && \
    printf 'DB_PORT=\"%s\"\n' \"\$DB_PORT\" >> .env && \
    printf 'DB_DATABASE=\"%s\"\n' \"\$DB_DATABASE\" >> .env && \
    printf 'DB_USERNAME=\"%s\"\n' \"\$DB_USERNAME\" >> .env && \
    printf 'DB_PASSWORD=\"%s\"\n' \"\$DB_PASSWORD\" >> .env && \
    printf 'SESSION_DRIVER=\"%s\"\n' \"\$SESSION_DRIVER\" >> .env && \
    printf 'CACHE_STORE=\"%s\"\n' \"\$CACHE_STORE\" >> .env && \
    printf 'ADMIN_EMAIL=\"%s\"\n' \"\$ADMIN_EMAIL\" >> .env && \
    printf 'ADMIN_PASSWORD=\"%s\"\n' \"\$ADMIN_PASSWORD\" >> .env && \
    php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed --class=AdminSeeder --force && \
    php artisan config:cache && \
    apache2-foreground"