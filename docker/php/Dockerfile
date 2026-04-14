FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql zip dom xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www