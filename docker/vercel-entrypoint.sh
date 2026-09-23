#!/bin/sh

set -eu

PORT="${PORT:-80}"

sed -ri "s/^Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

# Ensure each deployment recompiles Blade views from the current release.
php artisan view:clear >/dev/null 2>&1 || true

# Provision the first administrator only when explicit secure environment
# variables are present. The seeder never overwrites an existing account.
if [ -n "${ADMIN_EMAIL:-}" ] && [ -n "${ADMIN_PASSWORD:-}" ]; then
    if ! php artisan db:seed --class="Database\\Seeders\\AdminSeeder" --force; then
        echo "Warning: unable to provision the Sozo Habitat administrator." >&2
    fi
fi


exec "$@"