FROM php:8.1-fpm-alpine

RUN apk add icu-dev 

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-configure intl && docker-php-ext-install intl

COPY --from=composer:2.3.9 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

RUN mkdir -p /app && chown www-data:www-data /app
WORKDIR /app

USER www-data:www-data

COPY --chown=www-data:www-data ./app/composer.* ./
RUN composer install --optimize-autoloader --no-scripts

COPY --chown=www-data:www-data ./app ./
