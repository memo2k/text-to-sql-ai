#!/bin/bash
set -euo pipefail

cd /var/www

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-dev --optimize-autoloader --no-progress --no-interaction
fi

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is not set. Generate one with: php artisan key:generate --show"
    exit 1
fi

# Ensure Laravel can write logs, sessions, views, and cache
chmod -R ugo+rwX storage bootstrap/cache 2>/dev/null || true

# Wait for MySQL to accept connections (Render starts web + DB in parallel)
if [ "${DB_CONNECTION:-mysql}" = "mysql" ] && [ -n "${DB_HOST:-}" ]; then
    echo "Waiting for database at ${DB_HOST}..."
    for _ in $(seq 1 60); do
        if php artisan db:show --no-interaction >/dev/null 2>&1; then
            echo "Database is ready."
            break
        fi
        sleep 1
    done
fi

php artisan migrate --force --no-interaction

if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache --no-interaction
    php artisan route:cache --no-interaction
    php artisan view:cache --no-interaction
else
    php artisan config:clear --no-interaction
    php artisan route:clear --no-interaction
    php artisan view:clear --no-interaction
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
