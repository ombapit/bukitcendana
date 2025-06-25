FROM php:8.1-fpm

# Install system dependencies
RUN apt update && apt install -y curl zip unzip git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# (Opsional) Install ekstensi PHP Laravel biasa pakai
RUN docker-php-ext-install pdo pdo_mysql mbstring tokenizer

WORKDIR /var/www
