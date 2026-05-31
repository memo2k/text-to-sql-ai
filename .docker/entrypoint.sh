#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

php artisan cache:clear
php artisan config:clear
php artisan route:clear

if [ -n "${DB_HOST}" ] && [ "${DB_CONNECTION:-pgsql}" = "pgsql" ]; then
    echo "Waiting for PostgreSQL at ${DB_HOST}..."
    until php -r "
        try {
            new PDO(
                'pgsql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '5432') . ';dbname=' . getenv('DB_DATABASE'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
            exit(0);
        } catch (Throwable \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        sleep 2
    done
fi

exec php artisan serve --port="$PORT" --host=0.0.0.0 --env=.env
