FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libzip-dev

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# IMPORTANT: avoid scripts breaking install
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Then run Laravel commands separately
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000