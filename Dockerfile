# -----------------------------------------------------------------------------
# Frontend assets
# -----------------------------------------------------------------------------
FROM node:22-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# -----------------------------------------------------------------------------
# PHP dependencies (production)
# -----------------------------------------------------------------------------
FROM composer:2.8.12 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# -----------------------------------------------------------------------------
# Runtime image
# -----------------------------------------------------------------------------
FROM php:8.4 AS php

ARG UID=1000
ARG GID=1000

RUN apt-get update -y \
    && apt-get install -y --no-install-recommends unzip libcurl4-gnutls-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd -g "${GID}" appgroup \
    && useradd -u "${UID}" -g appgroup -m -s /bin/bash appuser

COPY --from=composer:2.8.12 /usr/bin/composer /usr/bin/composer
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY . .

RUN chown -R appuser:appgroup /var/www \
    && chmod -R ug+rwx storage bootstrap/cache

USER appuser

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
