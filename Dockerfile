FROM serversideup/php:8.4-fpm-nginx-alpine AS base

ENV AUTORUN_ENABLED=1
ENV PHP_OPCACHE_ENABLE=1
ENV SSL_MODE="off"

USER root

RUN apk add --update busybox-suid && \
    install-php-extensions bcmath gd exif

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER www-data

FROM base AS dependencies

WORKDIR /var/www/html/

# Cache the vendor files first
COPY composer.json composer.lock /var/www/html/

RUN mkdir -p app && \
    mkdir -p database/{factories,seeders} && \
    composer install --no-interaction --prefer-dist --no-scripts

USER root

RUN apk add --update nodejs npm

COPY ./package.json ./vite.config.js ./package-lock.json /var/www/html/
COPY ./public/ /var/www/html/public
COPY ./resources/ /var/www/html/resources

RUN npm ci && npm run build

FROM base

COPY --chown=www-data:www-data . /var/www/html

COPY --from=dependencies --chown=www-data:www-data /var/www/html/vendor /var/www/html/vendor
COPY --from=dependencies --chown=www-data:www-data /var/www/html/public/build /var/www/html/public/build

# Re-run install, but now with scripts and optimizing the autoloader...
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

USER root

RUN rm -rf /usr/bin/composer

USER www-data
