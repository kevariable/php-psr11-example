FROM php:8.2-fpm
LABEL authors="kevariable"

RUN apt-get update && apt-get install -y \
    git curl zip unzip

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www
