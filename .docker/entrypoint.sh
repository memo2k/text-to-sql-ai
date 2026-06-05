#!/bin/bash
set -e

# Fallback for local dev with bind-mounted source (docker-compose)
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ -n "${DB_HOST}" ] || [ -n "${DB_URL}" ] || [ -n "${DATABASE_URL}" ]; then
    echo "Waiting for database..."
    until php -r "
        try {
            if (\$url = getenv('DB_URL') ?: getenv('DATABASE_URL')) {
                \$parts = parse_url(\$url);
                \$host = \$parts['host'] ?? '127.0.0.1';
                \$port = \$parts['port'] ?? 3306;
                \$user = rawurldecode(\$parts['user'] ?? '');
                \$pass = rawurldecode(\$parts['pass'] ?? '');
                \$db = ltrim(\$parts['path'] ?? '', '/');
                \$dsn = \"mysql:host={\$host};port={\$port};dbname={\$db}\";
            } else {
                \$dsn = 'mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . getenv('DB_DATABASE');
                \$user = getenv('DB_USERNAME');
                \$pass = getenv('DB_PASSWORD');
            }
            new PDO(\$dsn, \$user, \$pass);
            exit(0);
        } catch (Throwable \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        sleep 2
    done
fi

if [ "${SEED_TECH_STORE}" = "true" ]; then
    php artisan migrate:fresh --force --no-interaction
    php artisan db:seed --force --no-interaction
else
    php artisan migrate --force --no-interaction
fi

if [ "${APP_ENV}" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
fi

exec php artisan serve --port="${PORT:-8000}" --host=0.0.0.0
