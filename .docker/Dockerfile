FROM php:8.4-cli-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache \
    libpq-dev \
    libzip-dev \
    git \
    zip \
    unzip  && \
    rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app