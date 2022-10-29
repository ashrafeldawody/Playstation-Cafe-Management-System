FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    libxml2-dev \
    libxslt-dev \
    libmcrypt-dev \
    libmemcached-dev \
    libmemcached-libs \
    libmemcachedutil2 \
    libmemcached-libsasl \
    libmemcached-libsasl-dev \
    # Install the PHP pdo_mysql extention \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
