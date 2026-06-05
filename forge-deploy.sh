#!/bin/bash
set -e

cd "$FORGE_SITE_PATH"

git pull origin "$FORGE_SITE_BRANCH"

$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build

if [ -f artisan ]; then
    php artisan migrate --force

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

if [ -f artisan ]; then
    php artisan queue:restart || true
fi
