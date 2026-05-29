#!/bin/bash
set -euo pipefail

cd /var/www

PORT="${PORT:-10000}"

# Fallback for local/docker-compose volume mounts without vendor in the image
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-interaction --no-dev --optimize-autoloader --no-progress
fi

php artisan migrate --force

if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
fi

if [ "${RUN_DB_SEED:-false}" = "true" ]; then
    php artisan db:seed --force
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT}"
