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

# Vercel ne fournit pas un fichier local pour le certificat Aiven.
# Le certificat est donc stockÃ© en base64 dans une variable d'environnement,
# puis reconstruit dans /tmp avant le dÃ©marrage d'Apache.
if [ -n "${AIVEN_CA_CERT_BASE64:-}" ]; then
    MYSQL_ATTR_SSL_CA="${MYSQL_ATTR_SSL_CA:-/tmp/aiven-ca.pem}"
    export MYSQL_ATTR_SSL_CA

    php -r '
        $encoded = getenv("AIVEN_CA_CERT_BASE64");
        $decoded = base64_decode($encoded, true);

        if ($decoded === false || $decoded === "") {
            fwrite(STDERR, "AIVEN_CA_CERT_BASE64 est invalide.\n");
            exit(1);
        }

        $path = getenv("MYSQL_ATTR_SSL_CA");

        if (file_put_contents($path, $decoded) === false) {
            fwrite(STDERR, "Impossible de crÃ©er le certificat Aiven.\n");
            exit(1);
        }
    '

    chmod 600 "$MYSQL_ATTR_SSL_CA"
fi

exec "$@"