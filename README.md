## Bukit Cendana

Webnya Bikit Cendana

Web Informasi warga dan pembayaran.

## Cara Install
- php artisan migrate
- php artisan make:filament-user (untuk membuat user admin)
- php artisan shield:generate --all (untuk generate role&permission)
- php artisan shield:super-admin

## Running in Docker
# Optional
# Install dependencies
apt update && apt install -y curl unzip git

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Tes
composer --version