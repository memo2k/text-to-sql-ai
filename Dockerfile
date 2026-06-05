FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm ci && npm run build


FROM php:8.4 AS php

ARG UID=1000
ARG GID=1000

RUN apt-get update -y \
    && apt-get install -y unzip libcurl4-gnutls-dev default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN groupadd -g ${GID} appgroup && \
    useradd -u ${UID} -g appgroup -m -s /bin/bash appuser

COPY --from=composer:2.8.12 /usr/bin/composer /usr/bin/composer

COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-progress --no-interaction --optimize-autoloader --no-scripts

COPY . .

COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && chown -R appuser:appgroup /var/www

USER appuser

ENV PORT=8000

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
